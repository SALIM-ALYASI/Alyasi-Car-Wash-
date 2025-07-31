<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة موعد جديد</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; background: #f8fafc; }
        .form-card { background: #fff; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.08); padding: 2rem; margin-top: 3rem; }
        h2 { color: #6366f1; font-weight: 700; }
        label { font-weight: 600; }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-card mx-auto" style="max-width: 600px;">
            <h2 class="mb-4 text-center">إضافة موعد جديد</h2>

            {{-- رسالة النجاح --}}
            @if(session('success'))
                <div class="alert alert-success text-center">{{ session('success') }}</div>
            @endif

            {{-- عرض الأخطاء --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form method="POST" action="{{ route('store_appointment') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">اسم العميل</label>
                    <input type="text" name="client_name" class="form-control" value="{{ old('client_name') }}" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">رقم جوال العميل</label>
                    <input type="text" name="client_phone" class="form-control" value="{{ old('client_phone') }}" required>
                </div>
                
             
                
                <input type="hidden" name="date" value="{{ now()->toDateString() }}">
                <input type="hidden" name="time" value="{{ now()->format('H:i') }}">
                
                <div class="mb-3">
                    <label class="form-label">نوع الغسيل</label>
                    <select name="wash_type_id" class="form-control" required>
                        <option value="">اختر نوع الغسيل</option>
                        @foreach($washTypes as $type)
                            <option value="{{ $type->id }}" {{ old('wash_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->name_ar }} - {{ $type->price }} ريال
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">رقم السيارة</label>
                    <input type="text" name="car_number" class="form-control" value="{{ old('car_number') }}" required>
                </div>
                
                <button type="submit" class="btn btn-primary w-100">💾 حفظ الموعد</button>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
