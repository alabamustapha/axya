<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Notifications\AdminPasswordChangeNotification;

class AppAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->only('adminPassword','adminPasswordForm');//'adminLogout',
        $this->middleware('adminauth')->only('adminLogin','adminLoginForm');
        $this->middleware('superadmin')->only('makeAdmin','makeStaff','makeNormal');
    }

    public function adminLoginForm(Request $request)
    {
        return view('admin.forms.admin-login');
    }

    public function adminPasswordForm(Request $request)
    {
        return view('admin.forms.admin-password');
    }

    public function adminLogin(Request $request)
    {
        $user = auth()->user();

        if ($user->admin_password === sha1($request->admin_password)) {
            $user->update(['admin_mode' => 1]);

            return redirect()->route('dashboard-main');
        }
        
        flash('We could not sign you in, check your login credentials and try again.')->error();
        return redirect()->back();
    }

    public function adminLogout(Request $request)
    {
        $user = auth()->user();

        if (Auth::user()->isLoggedInAsAdmin()) {
            $user->update(['admin_mode' => 0]);

            return redirect(route('user_dashboard'));
        }
    }

    public function adminPassword(Request $request)
    {
        $user = auth()->user();

        $this->authorize('edit', $user);

        // If there's an existing admin password, thus this is a password change request.
        if ($user->admin_password || $request->old_password){

            if (Auth::attempt([ 'email' => $user->email, 'password' => $request->password])) {        
                flash('Your admin portal password cannot be same as your normal user login password.')->error();
                return redirect()->back();
            }

            if ($user->admin_password === sha1($request->old_password)) {

                request()->validate([ 
                    'old_password' => 'required|string|min:8', 
                    'password'     => 'required|string|min:8|confirmed' 
                ]);

                if ($user->update(['admin_password' => sha1($request->password) ])) {
                    $user->notify(new AdminPasswordChangeNotification($user));

                    // Auth::logout();
                    flash('Admin account password changed successfully.')->success();// <b class="orange">Log in with the new password now.</b>
                    // return redirect()->route('users.show', $user);
                    return redirect()->route('dashboard-main');
                }            
            }

            flash('<b>The old admin password supplied is incorrect!</b> Account password change was not successful.')->error();
            // return redirect()->route('users.show', $user);
            return redirect()->route('dashboard-main');
        }
        else {
            request()->validate([ 'password' => 'required|string|min:8|confirmed' ]);

            if (Auth::attempt([ 'email' => $user->email, 'password' => $request->password])) {        
                flash('Your admin portal password cannot be same as your normal user login password.')->error();
                return redirect()->back();
            }

            if ($user->update([ 'admin_password' => sha1($request->password) ])) {
                $user->notify(new AdminPasswordChangeNotification($user));

                // Auth::logout();
                flash('Admin account password changed successfully.')->success();// <b class="orange">Log in with the new password now.</b>
                // return redirect()->route('users.show', $user);
                return redirect()->route('dashboard-main');
            }  
        }
    }



    public function makeAdmin(Request $request, User $user)
    {        
        $user = User::whereSlug($user->slug)->first();

        if (! $user->is_verified) {
            flash('This user\'s account has not been verified. A user must be verified to become an admin.');
            return back();
        }

        if ($user->acl == '1') {
            flash( '<b>'. $user->name .'</b> is already an ADMIN' )->info();
            return back(); 
        }        
        $user->makeAdmin();

        flash( '<b>'. $user->name .'\'s</b> access level changed to ADMIN Successfully' )->success();
        return back(); 
    }

    public function makeStaff(Request $request, User $user)
    {
        $user = User::whereSlug($user->slug)->first();

        if (! $user->is_verified) {
            flash('This user\'s account has not been verified. A user must be verified to become a staff.');
            return back();
        }

        if ($user->acl == '2'){
            flash( '<b>'. $user->name .'</b> is already a STAFF' )->info();
            return back();
        }

        $user->makeStaff();

        flash( '<b>'. $user->name .'\'s</b> access level changed to STAFF Successfully' )->success();
        return back(); 
    }

    public function makeNormal(Request $request, User $user)
    {
        $user = User::whereSlug($user->slug)->first();

        $user->makeOrdinaryMember();

        flash( '<b>'. $user->name .'\'s</b> access level changed to NORMAL Successfully' )->success();
        return redirect()->back(); 
    }
}
