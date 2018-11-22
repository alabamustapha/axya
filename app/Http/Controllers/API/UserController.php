<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\User\UserResource;
use App\Notifications\PasswordChangeNotification;
use App\Traits\CustomAuthorizationsTrait;
use App\Traits\ImageProcessing;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    use CustomAuthorizationsTrait, ImageProcessing;

    public function __construct()
    {
        $this->middleware('auth:api')->except('store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserResource::collection(User::paginate(15));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        // 1.
        $user = User::create([
            'name'     => $request['name'],
            'email'    => $request['email'],
            'gender'   => $request['gender'],
            'password' => Hash::make($request['password']),
            'dob'      => $request['dob'],
            'terms'    => $request['terms'],
        ]);

        // 2.
        // new User;
        // $user->name     = $request['name'];
        // $user->email    = $request['email'];
        // $user->gender   = $request['gender'];
        // $user->password = Hash::make($request['password']);
        // $user->dob      = $request['dob'];
        // $user->terms    = $request['terms'];
        // $user->save();

        return response()->json(new UserResource($user), Response::HTTP_CREATED);//201
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $user = User::whereSlug($slug)->firstOrFail();

        // dd($this->canViewUser($user));

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $slug)
    {
        $user = User::whereSlug($slug)->firstOrFail();

        $this->canEditUser($user);

        $user->update($request->all());

        return response()->json(new UserResource($user),  Response::HTTP_OK);//200
    }


    public function updateAllergies(Request $request, $slug)
    {
        $user = User::whereSlug($slug)->firstOrFail();

        $this->canEditUser($user);

        request()->validate(['allergies' => 'required|string|max:255']);
        
        $user->update(['allergies' => $request->allergies]);
        
        // flash('Profile updated successfully')->success();

        return response()->json(new UserResource($user),  Response::HTTP_OK);//200
    }


    public function updateChronics(Request $request, $slug)
    {
        $user = User::whereSlug($slug)->firstOrFail();

        $this->canEditUser($user);

        request()->validate(['chronics' => 'required|string|max:1500']);

        $user->update(['chronics' => $request->chronics]);
        
        // flash('Profile updated successfully')->success();

        return response()->json(new UserResource($user),  Response::HTTP_OK);//200
    }

    public function changePassword(Request $request, $slug)
    {
        $user = User::whereSlug($slug)->firstOrFail();

        $this->canEditUser($user);

        request()->validate([ 
            'password' => 'required|string|min:6|confirmed', 
            'password_confirmation' => 'required|string|min:6' 
        ]);

        if ($user->update(['password' => Hash::make($request['password']) ])){

            $user->notify(new PasswordChangeNotification($user));
        }
        
        return response()->json(new UserResource($user),  Response::HTTP_OK);//200 
    }


    public function avatarUpload(Request $request, $slug)
    {
        $user = User::whereSlug($slug)->firstOrFail();

        $this->canEditUser($user);

        $this->avatarProcessing($request, $user);

        // flash('Your profile image was successfully updated.')->success();

        return response()->json(new UserResource($user),  Response::HTTP_OK);//200 
    }


    public function avatarDelete(Request $request, $slug)
    {
        $user = User::whereSlug($slug)->firstOrFail();

        $this->canEditUser($user);

        $this->imageDeleteTrait($request, $user);

        // flash('Your profile image was successfully removed.')->success();

        return response()->json(new UserResource($user),  Response::HTTP_OK);//200
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $user = User::whereSlug($slug)->firstOrFail();

        $this->canRemoveUser($user);

        // If not cascaded, 
        // Delete $user->associated_model->each()->delete();
        $user->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);//204
    }
}
