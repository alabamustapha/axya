<?php

namespace App\Http\Controllers;

use App\Review;
use App\Doctor;
use App\Http\Requests\ReviewRequest;
use App\Notifications\Applications\ApplicationReceivedNotification;
use App\Notifications\Reviews\ReviewBookedNotification;
use App\Traits\TimeScheduleTrait;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    use TimeScheduleTrait;

    public function __construct()
    {
        $this->middleware('auth')->except('show', 'drindex');
        $this->middleware('verified')->except('show', 'drindex');
        // $this->middleware('admin')->only('index');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $reviews = $user->reviews()
                 // = Review::with(['doctor','doctor.specialty'])->where('user_id', $user->id)
                 ->latest()
                 ->paginate(25)
                 ;

        return view('reviews.index', compact('reviews', 'user'));
    }
    
    /**
     * Display a listing of the reviews resource for a doctor.
     *
     * @return \Illuminate\Http\Response
     */
    public function drindex(Doctor $doctor)
    {
        $reviews = $doctor->reviews()
                 ->latest()
                 ->paginate(25)
                 ;
        return view('doctors.models.reviews', compact('doctor', 'reviews'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReviewRequest $request)
    {
        $this->authorize('create', Review::class);

        $request->merge(['user_id' => auth()->id()]);

        $review = Review::create($request->all());

        if ($review){
            $review->appointment()->update(['rating' => $request->rating,'reviewed' => '1']);
            
            $message = 'Review submitted successfully.';

            if ($request->expectsJson()){
                return response(['message' => $message], 201);
            }

            flash($message)->success();
            return redirect()->back();//route('doctors.show', $review->doctor);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        return view('reviews.show', compact('review'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(ReviewRequest $request, Review $review)
    {
        $this->authorize('edit', $review);

        $request->merge(['user_id' => auth()->id()]);

        if ($review->update($request->all())){
            $message = 'Review updated successfully.';

            return response(['message' => $message], 200);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        $this->authorize('edit', $review);

        if ($review->delete()) {
            $message = 'Review deleted successfully';

            return response(['message' => $message], 204);
        }
    }
}
