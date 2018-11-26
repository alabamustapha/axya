<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AppAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('admin');
        $this->middleware('superadmin'); //->only('makeAdmin');
    }

    public function makeAdmin(Request $request, User $user)
    {        
        $user = User::whereSlug($user->slug)->first();

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
