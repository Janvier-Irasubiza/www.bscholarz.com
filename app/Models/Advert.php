<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advert extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'owner',
        'owner_phone',
        'type',
        'amount',
        'payment_circle',
        'amount_gen',
        'posted_on',
        'time_taken',
        'expiry_date',
        'media',
        'media_type',
        'status',
        'link',
        'clicks',
    ];

    protected $dates = [
        'posted_on',
        'taken_on',
        'expiry_date',
    ];
}
