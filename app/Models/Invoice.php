<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'appointment_id',
        'pdf_path',
        'status',
        'amount',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
