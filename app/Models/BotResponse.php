<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BotResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'keyword',
        'response',
        'type',
        'media_url',
        'status'
    ];
}
