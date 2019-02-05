<?php

namespace App\Http\Controllers;

use App\Doctor;
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
        $this->middleware('admin')->only('blockUser','unblockUser','licenseRevoke','licenseRestore');
        $this->middleware('superadmin')->only('makeAdmin','makeStaff','makeNormal');
    }

    /**
     * Check if user is available and not superadmin.
     */
    public function userCheck(Request $request, User $user)
    {
        if ( $user->isSuperAdmin() ) { 
            return abort(403);//response()->json( 'Super admin is unshakeable',  Response::HTTP_FORBIDDEN );//back(); = 403
        }

        if (! $user->is_verified) {
            return abort(406, 'This user\'s account has not been verified.');//HTTP_NOT_ACCEPTABLE = 406
            // flash('This user\'s account has not been verified. A user must be verified to become an admin.');
            // return back();
        }

        return;
    }

    /**
     *
     */
    public function makeAdmin(Request $request, User $user)
    {        
        $this->userCheck($request, $user);

        if ($user->acl == '1') {
            flash( '<b>'. $user->name .'</b> is already an ADMIN' )->info();
            return back(); 
        }        
        $user->changeAclTo('admin');
        // $user->makeAdmin();

        $message = $user->name .'\'s</b> access level changed to ADMIN Successfully.';
        return response()->json($message,  Response::HTTP_OK);//200

        // flash( '<b>'. $user->name .'\'s</b> access level changed to ADMIN Successfully' )->success();
        // return back(); 
    }

    public function makeStaff(Request $request, User $user)
    {
        $this->userCheck($request, $user);

        if ($user->acl == '2'){
            flash( '<b>'. $user->name .'</b> is already a STAFF' )->info();
            return back();
        }
 
        $user->changeAclTo('staff');
        // $user->makeStaff();

        $message = $user->name .'\'s</b> access level changed to STAFF Successfully.';
        return response()->json($message,  Response::HTTP_OK);//200

        // flash( '<b>'. $user->name .'\'s</b> access level changed to STAFF Successfully' )->success();
        // return back(); 
    }

    public function makeNormal(Request $request, User $user)
    {
        $this->userCheck($request, $user);

        $user->changeAclTo('normal');
        // $user->makeOrdinaryMember();

        $message = $user->name .'\'s</b> access level changed to NORMAL Successfully.';
        return response()->json($message,  Response::HTTP_OK);//200

        // flash( '<b>'. $user->name .'\'s</b> access level changed to NORMAL Successfully' )->success();
        // return redirect()->back(); 
    }



    /**
     * User related blocks.
     */
    public function blockUser(Request $request, User $user)
    {
        if ( $user->isSuperAdmin() ) { 
            return abort(403);
        }

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
