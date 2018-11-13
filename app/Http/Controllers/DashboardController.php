<?php

namespace App\Http\Controllers;

use App\Doctor;
use App\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users_count    = User::all()->count();
        $doctors_count  = Doctor::all()->count();
        // $completed_transactions_count  = Transaction::notverified()->count();
        // $successful_appointments_count = Appointment::notverified()->count();

        return view('admin.dashboard.index', compact(
            'users_count',
            'doctors_count'
            // 'completed_transactions_count',
            // 'successful_appointments_count',
        ));
    }

    public function users()
    {
        $users_count            = User::all()->count();
        $verified_users_count   = User::verified()->count();
        $unverified_users_count = User::notverified()->count();

        $male_users_count       = User::maleMembers()->count();
        $female_users_count     = User::femaleMembers()->count();
        $other_genders_count    = User::otherGenders()->count();

        $verified_users_stat    = ($users_count > 0) ? round((100 * ($verified_users_count / $users_count)), 1) : 0;
        $unverified_users_stat  = ($users_count > 0) ? round((100 * ($unverified_users_count / $users_count)), 1) : 0;

        $male_users_stat        = ($users_count > 0) ? round((100 * ($male_users_count / $users_count)), 1) : 0;
        $female_users_stat      = ($users_count > 0) ? round((100 * ($female_users_count / $users_count)), 1) : 0;
        $other_genders_stat     = ($users_count > 0) ? round((100 * ($other_genders_count / $users_count)), 1) : 0;

        return view('admin.dashboard.users', compact(
            'users_count',
            'verified_users_count',
            'unverified_users_count',

            'male_users_count',
            'female_users_count',
            'other_genders_count',

            'verified_users_stat',
            'unverified_users_stat',

            'male_users_stat',
            'female_users_stat',
            'other_genders_stat'
        ));
    }

    public function doctors()
    {
        return view('admin.dashboard.doctors');
    }

    public function admins()
    {
        $admins = User::whereIn('acl', [1,5])->orderBy('name')->get();
        $staffs = User::whereIn('acl', [2])->orderBy('name')->get();

        return view('admin.dashboard.admins', compact('admins','staffs'));
    }

    public function transactions()
    {
        return view('admin.dashboard.transactions');
    }
}
