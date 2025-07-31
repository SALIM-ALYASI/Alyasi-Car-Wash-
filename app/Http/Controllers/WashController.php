<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\WashStatus;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;


class WashController extends Controller
{
    // عرض صفحة إدخال الرمز
    public function start($id, Request $request)
    {
        // تحقق من صحة الحجز فقط بالمعرف
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return view('wash.invalid');
        }

        return view('wash.enter_pin', compact('appointment'));
    }

    // التحقق من الرمز السري
    public function verify($id, Request $request)
    {
        $pin = $request->input('pin');

        // رمز سري ثابت (يمكن وضعه في env)
        $correctPin = env('WASH_SECRET_PIN', '1234');

        if ($pin !== $correctPin) {
            return back()->withErrors(['pin' => '❌ الرمز غير صحيح']);
        }

        // تحديث حالة الطلب إلى منجز
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'done';
        $appointment->save();

        return view('wash.start', compact('appointment'));
    }

 public function sendInvoice($id)
{
    $appointment = Appointment::with('washType','client')->findOrFail($id);
    // إنشاء PDF وحفظه
    $pdfPath = storage_path("app/public/invoices/invoice_{$appointment->id}.pdf");
    if (!file_exists($pdfPath)) {
        $pdf = Pdf::loadView('invoices.receipt', compact('appointment'));
        $pdf->save($pdfPath);
    }

    // حفظ أو تحديث رقم الفاتورة
    $invoice = $appointment->invoice ?: new \App\Models\Invoice();
    $invoice->appointment_id = $appointment->id;
    $invoice->pdf_path = "invoices/invoice_{$appointment->id}.pdf";
    $invoice->status = 'sent';
    $invoice->amount = null;
    $invoice->save();

    // إعداد رسالة واتساب
    $invoiceUrl = route('wash.invoice.show', $appointment->id);
    $phone = $appointment->client->phone;
    $message = "🚗 الفاتورة لخدمة ({$appointment->washType->name_ar})\n📄 مشاهدتها هنا: {$invoiceUrl}";
// dd($phone);
    try {
        $response = Http::post('http://31.97.71.89:3002/send-message', [
            'phone' => $phone,
            'message' => $message
        ]);
        if ($response->failed()) {
            Log::error("فشل إرسال الفاتورة عبر API: " . $response->body());
            return response()->json([
                'status' => 'error',
                'message' => 'فشل إرسال الرسالة عبر واتساب.'
            ], 500);
        }
    } catch (\Exception $e) {
        Log::error("تعذّر الاتصال بخادم الإرسال: " . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'تعذر الاتصال بخادم الإرسال.'
        ], 500);
    }

    return response()->json([
        'status' => 'success',
        'message' => 'تم إرسال الفاتورة للعميل بنجاح.'
    ]);
}



    public function showInvoice($id)
    {
        $appointment = Appointment::with('washType', 'client')->findOrFail($id);
        return view('invoices.receipt', compact('appointment'));
    }
}
// 🚗 الفاتورة لخدمة (غسيل خارجي)
// 📄 مشاهدتها هنا: http://127.0.0.1:8000/invoice/4