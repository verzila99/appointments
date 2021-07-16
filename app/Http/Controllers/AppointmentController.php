<?php

namespace App\Http\Controllers;

use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function index()
    : array
    {
        return Appointment::All()->toArray();
    }
}
