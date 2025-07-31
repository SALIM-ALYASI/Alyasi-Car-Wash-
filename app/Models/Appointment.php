<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;

    // الحقول التي يمكن تعبئتها
protected $fillable = [
    'client_id',
    'wash_type_id',
    'date',
    'time',
    'car_number',
    'status',
    'reminded'
];


    /**
     * علاقة الحجز بالعميل
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * علاقة الحجز بحالة الغسيل (اختياري)
     */
    public function washStatus()
    {
        return $this->hasOne(WashStatus::class, 'appointment_id');
    }

    /**
     * علاقة الحجز بنوع الغسيل
     */
    public function washType()
    {
        return $this->belongsTo(WashType::class, 'wash_type_id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
