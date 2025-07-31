<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
            font-family: 'Cairo', sans-serif;
        }

        .dashboard-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            margin-top: 3rem;
        }

        h1 {
            color: #6366f1;
            font-weight: 700;
        }

        .stat {
            font-size: 1.2rem;
            color: #334155;
        }

        .table th,
        .table td {
            vertical-align: middle;
            text-align: center;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="dashboard-card text-center">
            <h1>لوحة التحكم</h1>
            <p class="mb-4">مرحباً بك في لوحة التحكم الخاصة بك.</p>

            <!-- زر إضافة موعد -->
            <a href="{{ route('add_appointment') }}" class="btn btn-success mb-4">
                <i class="bi bi-plus-circle"></i> إضافة موعد جديد
            </a>

            <!-- بطاقات الإحصائيات -->
            <div class="row g-4 justify-content-center">
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-primary">عدد الحجوزات اليوم</h5>
                            <p class="stat">{{ $appointmentsToday }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-success">عدد العملاء</h5>
                            <p class="stat">{{ $clientsCount }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-danger">الحجوزات الملغاة</h5>
                            <p class="stat">{{ $cancelledCount }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- جدول الحجوزات -->
        <div class="mt-5">
            <h2 class="mb-3 text-center text-secondary">جدول الحجوزات</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>رقم الفاتورة</th>
                            <th>العميل</th>
                            <th>تاريخ الفاتورة</th>
                            <th>المبلغ</th>
                            <th>نوع الغسيل</th>
                            <th>رقم السيارة</th>
                            <th>رابط الفاتورة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $invoice)
                        <tr>
                            <td>{{ $invoice->id }}</td>
                            <td>{{ $invoice->client?->name ?? '-' }}</td>
                            <td>{{ $invoice->created_at->format('Y-m-d') }}</td>
                            <td>{{ $invoice->amount }} ريال</td>
                            <td>{{ $invoice->washType?->name_ar ?? '-' }}</td>
                            <td>{{ $invoice->car_number }}</td>
                            <td>
                                <a href="{{ route('wash.invoice.show', $invoice->id) }}" class="btn btn-sm btn-primary" target="_blank">عرض الفاتورة</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">لا توجد فواتير اليوم</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
