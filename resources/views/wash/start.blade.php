<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>بدء غسيل السيارة</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background: #f8fafc;
        }

        .wash-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            margin-top: 4rem;
            max-width: 400px;
        }

        h1 {
            color: #6366f1;
            font-weight: 700;
        }

        p {
            font-size: 1.1rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="wash-card mx-auto text-center">
            <h1 class="mb-4">🚗 بدء غسيل السيارة</h1>
            <p>الطلب رقم: <strong>{{ $appointment->id }}</strong></p>
            <p>العميل: <strong>{{ $appointment->client->name }}</strong></p>
            <p>السيارة: <strong>{{ $appointment->car_number }}</strong></p>
            <p>نوع الغسيل: <strong>{{ $appointment->wash_type }}</strong></p>

            <form method="POST" action="{{ url('/wash/start/' . $appointment->id) }}">
                @csrf
                <button type="submit" class="btn btn-success w-100">✔️ إنهاء الخدمة</button>
            </form>

            <form method="POST" action="{{ url('/wash/start/' . $appointment->id . '/verify') }}" style="margin-top:15px;">
                @csrf
                <div class="mb-3">
                    <input type="text" name="pin" class="form-control" placeholder="أدخل الرمز السري للتحقق" required>
                </div>
                <button type="submit" class="btn btn-warning w-100">🔒 تحقق من الرمز السري</button>
            </form>

            <form id="invoiceForm" method="POST"
                action="{{ route('wash.invoice', $appointment->id) }}"
                style="margin-top:15px;">
                @csrf
                <button id="sendInvoiceBtn" type="submit"
                    style="background:blue;color:white;padding:10px 20px;border:none;border-radius:5px;">
                    إرسال الفاتورة 📄
                </button>
                <span id="invoiceLoading"
                    style="display:none;margin-right:10px;color:#6366f1;font-weight:bold;">
                    ⏳ جاري الإرسال...
                </span>
            </form>
            <div id="invoiceStatus" style="margin-top:10px;font-weight:bold;"></div>
 
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>



</body>

</html>