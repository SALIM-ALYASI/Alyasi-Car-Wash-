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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->unique(); // رقم الواتساب
            $table->string('name')->nullable(); // الاسم أو الإيموجي
            $table->integer('total_washes')->default(0); // عدد الغسلات
            $table->decimal('total_spent', 8, 2)->default(0); // إجمالي المبلغ
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
