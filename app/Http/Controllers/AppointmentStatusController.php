<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Notifications\Applications\ApplicationReceivedNotification;
use App\Notifications\Appointments\AppointmentBookedNotification;
use Illuminate\Http\Request;

class AppointmentStatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('doctor')->only('accept','reject');
        // $this->middleware('admin')->only('index');
    }

    public function complete(Request $request, Appointment $appointment)
    {
        $appointment->activateComplete();

        return response(['message' => 'Appointment/Consultation completed successfully.']);
    }

    public function accept(Request $request, Appointment $appointment)
    {
        $appointment->activateAccept();

        return response(['message' => 'Appointment accepted successfully.']);
    }

    public function reject(Request $request, Appointment $appointment)
    {
        $appointment->activateReject();

        return response(['message' => 'Appointment rejected.']);
    }

    public function cancel(Request $request, Appointment $appointment)
    {
        $appointment->activateCancel();

        return response(['message' => 'Appointment canceled.']);
    }

    public function payFee(Request $request, Appointment $appointment)
    {
        // $appointment->activateFeePayment();
        $appointment->activateFeePayment();

        return response(['message' => 'Appointment consultation fee paid.']);
    }
}
