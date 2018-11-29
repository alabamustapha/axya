<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Notifications\AccountVerificationNotification;
use App\Notifications\PasswordChangeNotification;
use App\Traits\ImageProcessing;
use App\Traits\CustomSluggableTrait;
use App\User;
use Auth;
use App\Image;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    use ImageProcessing, CustomSluggableTrait;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('patient'); // Prevents viewing another user's profile
        $this->middleware('verified')->only(['changePassword']);
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
    public function update(UserUpdateRequest $request, User $user)
    {
        $this->authorize('edit', $user);

        $this->updateSlug($request, $user);

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

        if (Auth::attempt([ 'email' => $user->email, 'password' => $request->old_password])) {

            request()->validate([ 
                'old_password' => 'required|string|min:6|', 
                'password'     => 'required|string|min:6|confirmed' 
            ]);

            if ($user->update(['password' => Hash::make($request['password']) ])) {
                $user->notify(new PasswordChangeNotification($user));

                // Auth::logout();
                flash('Account password changed successfully.')->success();// <b class="orange">Log in with the new password now.</b>
                return redirect()->route('users.show', $user);
            }            
        }

        flash('<b>The old password supplied is incorrect!</b> Account password change was not successful.')->error();
        return redirect()->route('users.show', $user);
    }



    public function avatarUpload(Request $request, User $user) 
    {
        $this->avatarProcessing($request, $user);

        flash('Your profile image was successfully updated.')->success();

        return redirect()->route('users.show', $user); 
    }

    // For Multiples Uploads Test.
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
        $this->authorize('delete', $user);
        // $user->images()->get()->each->delete();
        // $user->comments()->get()->each->delete();
        $user->delete();

        return redirect()->route('users.index');
    }
}
