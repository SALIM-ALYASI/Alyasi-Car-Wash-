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
        Schema::create('wash_types', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar'); // الاسم بالعربية
            $table->string('name_en'); // الاسم بالإنجليزية
            $table->decimal('price', 5, 2); // السعر
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wash_types');
    }
};
