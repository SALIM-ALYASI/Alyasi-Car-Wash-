<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Appointment;
use App\Models\WashStatus;

class BotController extends Controller
{
    // 📌 إنشاء أو جلب عميل
    public function storeClient(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string|max:20',
            'name'  => 'nullable|string|max:255'
        ]);

        $client = Client::firstOrCreate(
            ['phone' => $validated['phone']],
            ['name'  => $validated['name']]
        );

        return response()->json($client);
    }

    // 📌 جلب عميل حسب الرقم + تنظيف الحجوزات المنتهية
    public function getClient($phone)
    {
        $client = Client::where('phone', $phone)->first();

    if (!$client) {
        return response()->json([
            'status' => false,
            'message' => 'Client not found',
            'data' => null
        ], 404);
    }

    return response()->json([
        'status' => true,
        'data' => $client
    ]);
}

    // 📌 إنشاء حجز جديد
  public function storeAppointment(Request $request)
{
    $validated = $request->validate([
        'phone'         => 'required|string|max:20',
        'wash_type_id'  => 'required|exists:wash_types,id',
        'date'          => 'required|date',
        'time'          => 'required',
        'car_number'    => 'required|string'
    ]);

    // جلب أو إنشاء العميل
    $client = Client::firstOrCreate(['phone' => $validated['phone']]);

    // إنشاء الحجز
    $appointment = Appointment::create([
        'client_id'     => $client->id,
        'wash_type_id'  => $validated['wash_type_id'],
        'date'          => $validated['date'],
        'time'          => $validated['time'],
        'car_number'    => $validated['car_number'],
        'status'        => 'scheduled',
        'order_number'  => 'AQG-' . now()->format('Ymd') . '-' . strtoupper(substr(uniqid(), -4))
    ]);

    // 🔹 إنشاء رابط التأكيد
    $token = strtoupper(substr(uniqid(), -6)); // رمز أمني قصير
    $link = url("/wash/start/{$appointment->id}?token={$token}");

    // 🔹 حفظ حالة الغسيل في جدول wash_status
   WashStatus::create([
        'appointment_id' => $appointment->id,
        'link'           => $link,
        'status'         => 'pending'
    ]);

    // إضافة الرابط والـ token في الرد (يستخدم في QR Code)
    $appointment->confirmation_link = $link;

    return response()->json($appointment);
}


    // 📌 تحديث حالة الحجز
    public function updateAppointmentStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:scheduled,done,cancelled'
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->update(['status' => $validated['status']]);

        return response()->json($appointment);
    }

    // 📌 المواعيد المتاحة
    public function availableTimes(Request $request)
    {
        $date = $request->query('date');
        $start = 7;
        $end = 22;
        $available = [];

        for ($h = $start; $h < $end; $h++) {
            foreach (['00', '30'] as $m) {
                $time = sprintf('%02d:%s', $h, $m);
                $count = Appointment::where('date', $date)
                    ->where('time', $time)
                    ->count();
                if ($count < 2) {
                    $available[] = $time;
                }
            }
        }

        return response()->json($available);
    }

    // 📌 إضافة حالة الغسيل
    public function storeWashStatus(Request $request)
    {
        $validated = $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'link'           => 'required|string',
            'status'         => 'required|in:pending,completed'
        ]);

        $washStatus = WashStatus::create($validated);
        return response()->json($washStatus);
    }


    public function getActiveAppointments(Request $request)
    {
        $phone = $request->query('phone');
        $now = now(); // الوقت الحالي

        $appointments = Appointment::whereHas('client', function ($q) use ($phone) {
            $q->where('phone', $phone);
        })
            ->where('status', 'scheduled')
            ->where(function ($q) use ($now) {
                // تأكد أن الوقت لم يمر
                $q->where('date', '>', $now->toDateString())
                    ->orWhere(function ($q2) use ($now) {
                        $q2->where('date', '=', $now->toDateString())
                            ->where('time', '>=', $now->format('H:i:s'));
                    });
            })
            ->with('washType')
            ->get()
            ->map(function ($a) {
                return [
                    'id' => $a->id,
                    'date' => $a->date,
                    'time' => $a->time,
                    'wash_type' => $a->washType->name_ar,
                    'car_number' => $a->car_number
                ];
            });

        return response()->json($appointments);
    }
}
