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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id'); // رقم العميل بدون علاقة
            $table->date('date');
            $table->time('time');
            $table->string('car_number'); // رقم السيارة
            $table->enum('status', ['scheduled', 'done', 'cancelled'])->default('scheduled'); // حالة الحجز
            $table->boolean('reminded')->default(false); // التذكير
            $table->unsignedBigInteger('wash_type_id'); // نوع الغسيل بدون علاقة
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
