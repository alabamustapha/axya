<?php

namespace App\Http\Controllers;

use App\Application;
use App\Appointment;
use App\Doctor;
use App\Specialty;
use App\Subscription;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins_count           = User::whereIn('acl', [1,2,5])->get()->count();
        $users_count    = User::all()->count();
        $doctors_count  = Doctor::all()->count();
        // $completed_transactions_count  = Transaction::notverified()->count();
        // $completed_subscriptions_count = Subscription::completed()->count();
        $completed_appointments_count = Appointment::completed()->count();
        $successful_subscriptions_count = Subscription::completed()->count();
        $successful_transactions_count = Transaction::completed()->count();

        return view('admin.dashboard.index', compact(
            'admins_count',
            'users_count',
            'doctors_count',
            // 'completed_transactions_count',
            // 'completed_subscriptions_count',
            'completed_appointments_count',
            'successful_subscriptions_count',
            'successful_transactions_count'
        ));
    }

    public function users()
    {
        $users_count            = User::all()->count();
        $latest_users           = User::latest()->take(8)->get();

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
            'latest_users',
            
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
        $applications_count   = Application::all()->count();
        $doctors_count        = Doctor::all()->count();

        $male_doctors_count   = Doctor::maleMembers()->count();
        $female_doctors_count = Doctor::femaleMembers()->count();
        $other_genders_count  = Doctor::otherGenders()->count();

        $male_doctors_stat    = ($doctors_count > 0) ? round((100 * ($male_doctors_count / $doctors_count)), 1) : 0;
        $female_doctors_stat  = ($doctors_count > 0) ? round((100 * ($female_doctors_count / $doctors_count)), 1) : 0;
        $other_genders_stat   = ($doctors_count > 0) ? round((100 * ($other_genders_count / $doctors_count)), 1) : 0;

        $specialties    = Specialty::with('doctors')->get();
        $latest_doctors = Doctor::with('user')->latest()->take(8)->get();

        return view('admin.dashboard.doctors', compact(
            'applications_count',
            'doctors_count',

            'male_doctors_count',
            'female_doctors_count',
            'other_genders_count',

            'male_doctors_stat',
            'female_doctors_stat',
            'other_genders_stat',

            'specialties',
            'latest_doctors'
        ));
    }

    public function admins()
    {
        $admins_count = User::whereIn('acl', [1,2,5])->get()->count();
        $admins       = User::whereIn('acl', [1,5])->orderBy('name')->get();
        $staffs       = User::whereIn('acl', [2])->orderBy('name')->get();

        return view('admin.dashboard.admins', compact('admins','staffs','admins_count'));
    }

    public function subscriptions()
    {
        $successful_subscriptions_count = Subscription::completed()->count();

        // Display/Group by Date...
        $subscriptions = Subscription::latest()
                                    ->paginate(15);
        // return view('subscriptions.admin', compact('subscriptions'));
        return view('admin.dashboard.subscriptions', compact('subscriptions','successful_subscriptions_count'));
    }

    public function transactions()
    {
        $successful_transactions_count = Transaction::completed()->count();

        // Display/Group by Date...
        $transactions = Transaction::latest()
                                    ->paginate(15);
        // return view('transactions.admin', compact('transactions'));
        return view('admin.dashboard.transactions', compact('transactions','successful_transactions_count'));
    }

    // public function transactions()
    // {
    //     return view('admin.dashboard.transactions');
    // }


    public function listAdmins()
    {
        $admins = User::whereIn('acl', [1,5])->orderBy('name')->paginate(10);

        return response()->json($admins);
    }

    public function listStaffs()
    {
        $staffs = User::whereIn('acl', [2])->orderBy('name')->paginate(10);

        return response()->json($staffs);
    }
}
