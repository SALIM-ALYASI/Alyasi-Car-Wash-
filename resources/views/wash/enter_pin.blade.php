<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدخال الرمز السري - AquaGo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; background: #f8fafc; }
        .pin-card { background: #fff; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.08); padding: 2rem; margin-top: 4rem; max-width: 400px; }
        h2 { color: #6366f1; font-weight: 700; }
        label { font-weight: 600; }
    </style>
</head>
<body>
    <div class="container">
        <div class="pin-card mx-auto">
            <h2 class="mb-4 text-center">🔐 تأكيد الوصول</h2>
            <p class="text-center">رقم الطلب: <strong>{{ $appointment->id }}</strong></p>

            @if($errors->any())
                <div class="alert alert-danger text-center">{{ $errors->first('pin') }}</div>
            @endif

            <form method="POST" action="{{ route('wash.verify', $appointment->id) }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">أدخل الرمز السري:</label>
                    <input type="password" name="pin" class="form-control text-center" required autofocus>
                </div>
                <button type="submit" class="btn btn-primary w-100">تأكيد</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
