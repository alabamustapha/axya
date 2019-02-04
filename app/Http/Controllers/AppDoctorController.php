<?php

namespace App\Http\Controllers;

use App\Doctor;
use App\Notifications\Doctors\DoctorPasswordChangeNotification;
use App\Notifications\Doctors\DoctorPasswordResetNotification;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AppDoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('doctorguest')->except('doctorLogout');
    }

    /**
     * Doctor logs into the doctor portal with this form.
     */
    public function doctorLoginForm(Request $request)
    {
        return view('doctors.forms.auth-doctor-login');
    }

    /**
     *
     */
    public function doctorLogin(Request $request)
    {
        $user = auth()->user();

        if ($user->doctor_password === sha1($request->doctor_password)) {
            $user->update(['doctor_mode' => 1]);

            return redirect()->route('dr_dashboard', $user->doctor);
        }
        
        flash('We could not sign you in, check your login credentials and try again.')->error();
        return redirect()->back();
    }

    /**
     * Log a doctor out of the doctor's dashboard.
     */
    public function doctorLogout(Request $request)
    {
        $user = auth()->user();

        if ($user->isLoggedInAsDoctor()) {
            $user->update(['doctor_mode' => 0]);

            return redirect(route('user_dashboard'));
        }
    }

    /**
     * Form: Doctor create a New or Change existing doctor password.
     */
    public function passwordNewOrChangeForm(Request $request)
    {
        return view('doctors.forms.auth-password-new-or-change');
    }

    /**
     * Script: Doctor create a New or Change existing doctor password.
     */
    public function passwordNewOrChange(Request $request)
    {
        $user = auth()->user();

        $this->authorize('edit', $user);

        if (Auth::attempt([ 'email' => $user->email, 'password' => $request->password])) {        
            flash('Your doctor portal password cannot be same as your normal user login password.')->error();
            return redirect()->back();
        }

        if ($user->doctor_password || $request->old_password){

            if ($user->doctor_password === sha1($request->old_password)) {

                request()->validate([ 
                    'old_password' => 'required|string|min:8', 
                    'password'     => 'required|string|min:8|confirmed' 
                ]);

                if ($user->update([ 'doctor_password' => sha1($request->password) ])) {
                    $user->notify(new DoctorPasswordChangeNotification($user));

                    // Auth::logout();
                    flash('Doctor account password changed successfully.')->success();

                    return redirect()->route('dashboard-main');
                }            
            }

            flash('<b>The old doctor password supplied is incorrect!</b> Account password change was not successful.')->error();

            return redirect()->route('dashboard-main');
        }
        else {
            request()->validate([ 'password' => 'required|string|min:8|confirmed' ]);

            if ($user->update([ 'doctor_password' => sha1($request->password) ])) {

                $user->notify(new DoctorPasswordChangeNotification($user));

                flash('Your doctor account password was changed successfully. Sign in now with the new password')->warning()->important();

                return redirect(route('doctor.login'));
                // return redirect()->route('dashboard-main');
            }  
        }
    }




    /**
     * 1. Form: To collect email for verification. :GET
     */
    public function passwordResetEmailForm(Request $request)
    {
        return view('doctors.forms.auth-password-reset-form');
    }

    /**
     * 2. To verify email and send Password Reset Link. :POST Script.
     */
    public function passwordResetEmailLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = auth()->user();

        if ($user->is_doctor_user && ($user->email === $request->email)) {
            
            // Send Reset Email: Contains the reset link.
            $user->notify(new DoctorPasswordResetNotification($user));

            flash('Doctor password reset email has been sent to your email <strong>'.$request->email.'</strong>, use the link to reset your doctoristrators password.')->success()->important();
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

            return redirect(route('doctor.password.reset-change-form'));
        }

        flash('Invalid/Expired Password Reset Link, try again.')->error();

        return redirect(route('doctor.password.reset-email-form'));
    }

    /**
     * 4. Form: To input new password, confirm it and send. :GET.
     */
    public function passwordResetChangeForm(Request $request)
    {
        return view('doctors.forms.auth-password-reset-change');
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
            flash('Your doctor portal password cannot be same as your normal user login password.')->error();
            return redirect()->back();
        }

        if ($user->verification_link == null) {
            flash('Invalid/Expired Password Reset Link, try again.')->error();
        
            return redirect(route('doctor.password.reset-email-form'));
        }

        $updatedDoctor = $user->update([ 
                'doctor_password'    => sha1($request->password), 
                'verification_link' => null,
                // 'doctor_mode' => 1 
            ]);
        // dd($updatedDoctor, $user->verification_link);

        if ($updatedDoctor) {            
            // $user->notify(new DoctorPasswordFullyResetNotification($user));

            flash('Your doctor account password was reset successfully. Sign in now with the new password.')->warning()->important();

            return redirect()->route('doctor.login');
        } 
    }



    /**
     * Revoke doctor's license.
     */
    public function licenseRevoke(Request $request, Doctor $doctor)
    {
        $doctor->revokeLicense();

        return response()->json('Dr. '. $doctor->name .'\'s license is now revoked on this platform.',  Response::HTTP_OK);//200
    }

    /**
     * Restore doctor's license.
     */
    public function licenseRestore(Request $request, Doctor $doctor)
    {
        $doctor->restoreLicense();

        return response()->json('Dr. '. $doctor->name .'\'s license is now restored back on this platform.',  Response::HTTP_OK);//200
    }
}
