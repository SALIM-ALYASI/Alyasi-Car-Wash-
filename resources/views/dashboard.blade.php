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
                            <th>العميل</th>
                            <th>تاريخ الحجز</th>
                            <th>الوقت</th>
                            <th>نوع الغسيل</th>
                            <th>رقم السيارة</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->client?->name ?? '-' }}</td>
                            <td>{{ $appointment->date }}</td>
                            <td>{{ $appointment->time }}</td>
                            <td>
                                @if($appointment->washType)
                                    {{ $appointment->washType->name_ar }} - {{ $appointment->washType->price }} ريال
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $appointment->car_number }}</td>
                            <td>
                                @if($appointment->status == 'scheduled')
                                    <span class="badge bg-primary"><i class="bi bi-clock"></i> مجدول</span>
                                @elseif($appointment->status == 'done')
                                    <span class="badge bg-success"><i class="bi bi-check-circle"></i> منجز</span>
                                @elseif($appointment->status == 'cancelled')
                                    <span class="badge bg-danger"><i class="bi bi-x-circle"></i> ملغى</span>
                                @else
                                    <span class="badge bg-secondary">غير معروف</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">لا توجد حجوزات</td>
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
