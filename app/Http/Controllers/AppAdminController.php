<?php

namespace App\Http\Controllers;

use App\Notifications\Admin\AdminPasswordChangeNotification;
use App\Notifications\Admin\AdminPasswordResetNotification;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AppAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('admin')->only('passwordNewOrChange','passwordNewOrChangeForm');//'adminLogout',
        $this->middleware('adminauth')->except('makeAdmin','makeStaff','makeNormal');//->only('adminLogin','adminLoginForm','passwordResetEmail','passwordResetEmailLink','passwordResetEmailLinkVerify','passwordResetChangeForm','passwordResetChange');
        $this->middleware('superadmin')->only('makeAdmin','makeStaff','makeNormal');
    }

    /**
     * Admin logs into the admin portal with this form.
     */
    public function adminLoginForm(Request $request)
    {
        return view('admin.forms.admin-login');
    }

    /**
     *
     */
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

    /**
     *
     */
    public function adminLogout(Request $request)
    {
        $user = auth()->user();

        if ($user->isLoggedInAsAdmin()) {
            $user->update(['admin_mode' => 0]);

            return redirect(route('user_dashboard'));
        }
    }

    /**
     * Form: Admin create a New or Change existing admin password.
     */
    public function passwordNewOrChangeForm(Request $request)
    {
        return view('admin.forms.password-new-or-change');
    }

    /**
     * Script: Admin create a New or Change existing admin password.
     */
    public function passwordNewOrChange(Request $request)
    {
        $user = auth()->user();

        $this->authorize('edit', $user);

        if (Auth::attempt([ 'email' => $user->email, 'password' => $request->password])) {        
            flash('Your admin portal password cannot be same as your normal user login password.')->error();
            return redirect()->back();
        }

        if ($user->admin_password || $request->old_password){

            if ($user->admin_password === sha1($request->old_password)) {

                request()->validate([ 
                    'old_password' => 'required|string|min:8', 
                    'password'     => 'required|string|min:8|confirmed' 
                ]);

                if ($user->update([ 'admin_password' => sha1($request->password) ])) {
                    $user->notify(new AdminPasswordChangeNotification($user));

                    // Auth::logout();
                    flash('Admin account password changed successfully.')->success();

                    return redirect()->route('dashboard-main');
                }            
            }

            flash('<b>The old admin password supplied is incorrect!</b> Account password change was not successful.')->error();

            return redirect()->route('dashboard-main');
        }
        else {
            request()->validate([ 'password' => 'required|string|min:8|confirmed' ]);

            if ($user->update([ 'admin_password' => sha1($request->password) ])) {

                $user->notify(new AdminPasswordChangeNotification($user));

                flash('Your admin account password was changed successfully. Sign in now with the new password')->warning()->important();

                return redirect(route('admin.login'));
                // return redirect()->route('dashboard-main');
            }  
        }
    }




    /**
     * 1. Form: To collect email for verification. :GET
     */
    public function passwordResetEmailForm(Request $request)
    {
        return view('admin.forms.password-reset-form');
    }

    /**
     * 2. To verify email and send Password Reset Link. :POST Script.
     */
    public function passwordResetEmailLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = auth()->user();

        if ($user->is_admin_user && ($user->email === $request->email)) {
            
            // Send Reset Email: Contains the reset link.
            $user->notify(new AdminPasswordResetNotification($user));

            flash('Admin password reset email has been sent to your email <strong>'.$request->email.'</strong>, use the link to reset your administrators password.')->success()->important();
            return back();
        }
        
        flash('We could not find your email in the database, type it correctly and try again.')->error();
        return back();
    }

    /**
     * 3. Links in from mail, Verifies correctness of reset link payload and 
     *    Redirects to new password creation form. :GET.
     */
    public function passwordResetEmailLinkVerify(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required',
            'tc'    => 'required',
        ]);

        $user = auth()->user();

        if (request()->token == $user->verification_link && 
            request()->tc    == md5($user->created_at) &&
            request()->email == urldecode($user->email)
           ){
            
            flash('Successful account confirmation, create a new password with the form below.')->success()->important();

            return redirect(route('admin.password.reset-change-form'));
        }

        flash('Invalid/Expired Password Reset Link, try again.')->error();

        return redirect(route('admin.password.reset-email-form'));
    }

    /**
     * 4. Form: To input new password, confirm it and send. :GET.
     */
    public function passwordResetChangeForm(Request $request)
    {
        return view('admin.forms.password-reset-change');
    }

    /**
     * 5. Script: To persist new password to DB :PATCH Script.
     */
    public function passwordResetChange(Request $request)
    {
        $user = auth()->user();

        $this->authorize('edit', $user);

        request()->validate([ 'password' => 'required|string|min:8|confirmed' ]);

        if (Auth::attempt([ 
                'email'    => $user->email, 
                'password' => $request->password
            ])) {        
            flash('Your admin portal password cannot be same as your normal user login password.')->error();
            return redirect()->back();
        }

        if ($user->verification_link == null) {
            flash('Invalid/Expired Password Reset Link, try again.')->error();
        
            return redirect(route('admin.password.reset-email-form'));
        }

        $updatedAdmin = $user->update([ 
                'admin_password'    => sha1($request->password), 
                'verification_link' => null,
                // 'admin_mode' => 1 
            ]);
        // dd($updatedAdmin, $user->verification_link);

        if ($updatedAdmin) {            
            // $user->notify(new AdminPasswordFullyResetNotification($user));

            flash('Your admin account password was reset successfully. Sign in now with the new password.')->warning()->important();

            return redirect()->route('admin.login');
        } 
    }







    /**
     * Check if user is available and not superadmin.
     */
    public function userCheck(Request $request, User $user)
    {        
        $user = User::whereSlug($user->slug)->first();
        
        if ( $user->isSuperAdminUser() ) { return back(); }

        return;
    }

    /**
     *
     */
    public function makeAdmin(Request $request, User $user)
    {        
        $this->userCheck($request, $user);

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
        $this->userCheck($request, $user);

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
        $this->userCheck($request, $user);

        $user->makeOrdinaryMember();

        flash( '<b>'. $user->name .'\'s</b> access level changed to NORMAL Successfully' )->success();
        return redirect()->back(); 
    }



    /**
     * User related blocks.
     */
    public function blockUser(Request $request, User $user)
    {
        $this->userCheck($request, $user);

        $user->block();

        return response()->json($user->name .' is now blocked on this platform.',  Response::HTTP_OK);//200

        // flash( '<b>'. $user->name .' is now blocked on this platform.' )->success();
        // return redirect()->back(); 
    }

    public function unblockUser(Request $request, User $user)
    {
        $this->userCheck($request, $user);

        $user->unblock();

        return response()->json($user->name .' is now unblocked.',  Response::HTTP_OK);//200

        // flash( '<b>'. $user->name .' is now unblocked.' )->success();
        // return redirect()->back(); 
    }
}
