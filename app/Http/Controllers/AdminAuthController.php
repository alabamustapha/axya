<?php

namespace App\Http\Controllers;

use App\Notifications\Admin\AdminPasswordChangeNotification;
use App\Notifications\Admin\AdminPasswordResetNotification;
use App\User;
use Auth;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('adminauth')->except('adminLogout');
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

            if (isset(request()->ref)){
                // Prevent double slash '//' if referring url is '/'.
                $refUrl = (request()->ref === '/') ? '' : request()->ref;

                // Reconstruct referring page and redirect appropriately.
                $expected_path = config('app.url') . $refUrl;

                return redirect($expected_path);
            }

            return redirect()->route('dashboard-main');
        }
        
        flash('We could not sign you in, check your login credentials and try again.')->error();
        return redirect()->back();
    }

    /**
     * Log an admin out of the admin dashboard.
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

        if ($user->is_admin && ($user->email === $request->email)) {
            
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
}
