<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Instructor;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppointmentController extends Controller
{
    public function index(): array
    {
        return Appointment::with('instructor')
            ->where('user_id', auth()->user()->id)
            ->where('start_time', '>', Carbon::now())
            ->get()
            ->toArray();
    }


    public function all(): array
    {
        $appointments = Appointment::with('instructor:id,name')
            ->select(['id', 'start_time', 'instructor_id', 'user_id'])
            ->get()
            ->toArray();
        $instructors = Instructor::All()->toArray();

        return ['appointments' => $appointments, 'instructors' => $instructors];
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
            'instructor' => 'required|numeric',
            'time'       => 'required|string',
            ]
        );

        if (Appointment::where('user_id', auth()->user()->id)->where('start_time', $validated['time'])->count() > 0
        ) {
            return response('You already have record on this time.', 400);
        }

        if (Appointment::where('user_id', auth()->user()->id)->whereDay('start_time', Carbon::create($validated['time'])->day)->count() > 2
        ) {
            return response('You can\'t have more than 2 record on 1 day.', 400);
        }
        $appointment = Appointment::create(
            [
            'start_time'    => $validated['time'],
            'instructor_id' => $validated['instructor'],
            'user_id'       => auth()->user()->id,
            ]
        );

        return $appointment->toArray();
    }

    public function destroy($id): \Illuminate\Http\Response |
    int | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory
    {
        if (is_numeric($id)
            && Appointment::where('user_id', auth()->user()->id)->where('id', $id)->count() > 0
        ) {
            return Appointment::destroy($id);
        }
        if (is_numeric($id) && auth()->user()->role > 0 && Appointment::where('id', $id)->count() > 0) {
            return Appointment::destroy($id);
        }

        return response('Record not found.', 400);
    }


}
