<?php

namespace App\Http\Controllers;


use App\Models\Instructor;

class InstructorController extends Controller
{
    public function index()
    : array
    {
        return Instructor::All()->toArray();
    }
}
