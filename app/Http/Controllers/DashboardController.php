<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Client;
use App\Models\WashType;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
{
    // إحصائيات
    $today = now()->toDateString();
    $appointmentsToday = Appointment::where('date', $today)->count();
    $clientsCount = Client::count();
    $cancelledCount = Appointment::where('status', 'cancelled')->count();

// جلب حجوزات تاريخ اليوم
$appointments = Appointment::with(['client', 'washType'])
    ->whereDate('date', Carbon::today()) // فلترة على تاريخ اليوم
    ->latest()
    ->take(10)
    ->get();
    return view('dashboard', [
        'appointmentsToday' => $appointmentsToday,
        'clientsCount' => $clientsCount,
        'cancelledCount' => $cancelledCount,
        'appointments' => $appointments,
    ]);
}

public function storeAppointment(Request $request)
{
    $validated = $request->validate([
        'client_name'   => 'required|string|max:255',
        'client_phone'  => 'required|string|max:20',
        'date'          => 'required|date',
        'time'          => 'required',
        'wash_type_id'  => 'required|exists:wash_types,id', // نوع الغسيل مرتبط بالجدول الجديد
        'car_number'    => 'required|string',
    ]);

    // حفظ أو جلب العميل
    $client = Client::firstOrCreate(
        ['phone' => $validated['client_phone']],
        ['name' => $validated['client_name']]
    );

    // حفظ الحجز
    Appointment::create([
        'client_id'     => $client->id,
        'wash_type_id'  => $validated['wash_type_id'],
        'date'          => $validated['date'],
        'time'          => $validated['time'],
        'car_number'    => $validated['car_number'],
        'status'        => 'scheduled',
    ]);

    return redirect()->route('dashboard')->with('success', 'تم حفظ الحجز بنجاح');
}
public function addAppointment()
{
    $washTypes = WashType::all();
    // dd($washTypes);
    return view('add_appointment', compact('washTypes'));
}


}