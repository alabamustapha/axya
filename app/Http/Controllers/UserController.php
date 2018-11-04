<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersUpdateRequest;
use App\Notifications\AccountVerificationNotification;
use App\Notifications\PasswordChangeNotification;
use App\Traits\ImageProcessing;
use App\User;
use App\Image;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    use ImageProcessing;

    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('patient');
        $this->middleware('verified')->only(['changePassword']);
        $this->middleware('owner')->only(['edit', 'update']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('edit', $user);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UsersUpdateRequest $request, User $user)
    {
        $this->authorize('edit', $user);

        $user->update($request->all());
        
        flash('Profile updated successfully')->success();

        return redirect()->route('users.show', $user);
    }

    public function updateAllergies(Request $request, User $user)
    {
        $this->authorize('edit', $user);
        request()->validate(['allergies' => 'required|string|max:255']);
        
        $user->update($request->all());
        
        flash('Profile updated successfully')->success();

        return redirect()->route('users.show', $user);
    }

    public function updateChronics(Request $request, User $user)
    {
        $this->authorize('edit', $user);
        request()->validate(['chronics' => 'required|string|max:1500']);

        $user->update($request->all());
        
        flash('Profile updated successfully')->success();

        return redirect()->route('users.show', $user);
    }

    public function changePassword(Request $request, User $user)
    {
        $this->authorize('edit', $user);
        request()->validate([ 'password' => 'required|string|min:6|confirmed' ]);

        if ($user->update(['password' => Hash::make($request['password']) ])){

            $user->notify(new PasswordChangeNotification($user));

            flash('Account password changed successfully.')->success();
        }
        else {
            flash('Account password change was unsuccessful.')->error();
        }
        
        return redirect()->route('users.show', $user);
    }



    public function avatarUpload(Request $request, User $user) 
    {
        $this->avatarProcessing($request, $user);

        flash('Your profile image was successfully updated.')->success();

        return redirect()->route('users.show', $user); 
    }

    public function imageUpload(Request $request, User $user) 
    {
        $this->imageProcessing($request, $user);
        
        flash('Image was successfully updated.')->success();

        return redirect()->route('users.show', $user); 
    }

    public function avatarDelete(Request $request, User $user) 
    {       
        $this->imageDeleteTrait($request, $user);

        flash('Your profile image was successfully removed.')->success();

        return redirect()->route('users.show', $user);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // $user->images()->get()->each->delete();
        // $user->comments()->get()->each->delete();
        $user->delete();

        return redirect()->route('users.index');
    }
}
