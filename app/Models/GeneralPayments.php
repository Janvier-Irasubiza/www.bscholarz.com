<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralPayments extends Model
{
    use HasFactory;

    protected $table = 'general_payments';

    protected $fillable = [
        'type',
        'amount',
        'names',
        'email',
        'phone',
        'description',
        'status',
        'transaction_id',
        'pcode',
    ];
}
