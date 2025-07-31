<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WashType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'price'
    ];

    // علاقة: نوع الغسيل له حجوزات
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
