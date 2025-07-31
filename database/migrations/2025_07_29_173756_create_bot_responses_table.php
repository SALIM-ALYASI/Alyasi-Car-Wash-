<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bot_responses', function (Blueprint $table) {
            $table->id();
            $table->string('keyword')->unique(); // الكلمة المفتاحية
            $table->text('response'); // النص
            $table->enum('type', ['text', 'image', 'video'])->default('text'); // نوع الرد
            $table->string('media_url')->nullable(); // رابط الوسائط
            $table->boolean('status')->default(true); // مفعّل أو لا
            $table->string('language', 5)->default('ar'); // لغة الرد (ar / en / ...)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bot_responses');
    }
};
