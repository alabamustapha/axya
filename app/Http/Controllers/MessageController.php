<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = auth()->user()->messages()->paginate(20);

        return view('messages.index', compact('messages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MessageRequest $request)
    {
        $this->authorize('create', Message::class);        

        $request->merge(['user_id' => auth()->id()]);
        
        $message = Message::create($request->all());

        if ($message) {
            $msg = 'Message added successfully';

            if (request()->expectsJson()) {
                return response(['status' => $msg]);
            }
        }

        return redirect()->route('appointments.show', $message->messageable);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        $this->authorize('delete', $message);

        $message->delete();
        $msg = 'Message deleted successfully';

        // if ($message->delete()) {
        //     if ($request->expectsJson()) {
        //         return response(['message' => $msg]);
        //     }
        // }

        flash($msg)->info();
        return redirect()->route('appointments.show', $message->messageable);
    }
}
