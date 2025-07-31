<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'name',
        'total_washes',
        'total_spent'
    ];

    // علاقة: العميل لديه عدة حجوزات
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}

