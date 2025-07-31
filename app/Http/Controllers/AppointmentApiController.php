<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentApiController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with('client')->latest()->get();
        return response()->json($appointments);
    }
}
