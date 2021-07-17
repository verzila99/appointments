<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    : array
    {
        return Appointment::All()->toArray();
    }


    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'instructor' => 'required|numeric',
                'time'       => 'required|string'
            ]
        );
        abort_if(!auth()->check(), 403);

        $appointment = Appointment::create(
            ['start_time'    => $validated['time'],
             'instructor_id' => $validated['instructor'],
             'user_id'       => auth()->user()->id]
        );

        return $appointment->toArray();
    }
}
