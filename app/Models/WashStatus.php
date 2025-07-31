<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WashStatus extends Model
{
    use HasFactory;
protected $table = 'wash_status';

    protected $fillable = [
        'appointment_id',
        'link',
        'status'
    ];

    // علاقة: حالة الغسيل تخص حجز
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
