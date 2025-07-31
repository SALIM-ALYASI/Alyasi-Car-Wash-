<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>فاتورة غسيل السيارة</title>
    <style>
        body { font-family: 'Cairo', Tahoma, Arial, sans-serif; background: #fff; margin: 0; padding: 0; }
        .invoice-box {
            max-width: 600px;
            margin: 40px auto;
            padding: 32px 24px;
            border: 2px solid #6366f1;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            background: #f8fafc;
        }
        .header {
            text-align: center;
            margin-bottom: 24px;
        }
        .header h2 {
            color: #6366f1;
            font-size: 28px;
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }
        th, td {
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
            font-size: 16px;
        }
        th {
            color: #6366f1;
            font-weight: 700;
            width: 35%;
        }
        .total {
            font-size: 20px;
            font-weight: bold;
            color: #16a34a;
            text-align: left;
        }
        .footer {
            text-align: center;
            color: #6366f1;
            margin-top: 24px;
            font-size: 15px;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="header">
            <h2>🚗 AquaGo - فاتورة الخدمة</h2>
        </div>
        <table>
            <tr>
                <th>رقم الطلب</th>
                <td>{{ $appointment->id }}</td>
            </tr>
            <tr>
                <th>اسم العميل</th>
                <td>{{ $appointment->client->name }}</td>
            </tr>
            <tr>
                <th>رقم السيارة</th>
                <td>{{ $appointment->car_number }}</td>
            </tr>
            <tr>
                <th>نوع الغسيل</th>
                <td>{{ $appointment->washType->name_ar ?? '-' }}</td>
            </tr>
            <tr>
                <th>تاريخ الحجز</th>
                <td>{{ $appointment->date }}</td>
            </tr>
            <tr>
                <th>الوقت</th>
                <td>{{ $appointment->time }}</td>
            </tr>
            <tr>
                <th>السعر</th>
                <td>{{ $appointment->washType->price ?? '-' }} ريال</td>
            </tr>
        </table>
        <p class="total">الإجمالي: {{ $appointment->washType->price ?? '-' }} ريال</p>
        <div class="footer">شكراً لاستخدامك خدمة AquaGo 🚗</div>
    </div>
</body>
</html>
