<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'sender',
        'receiver',
        'app',
        'transaction',
        'account',
        'status',
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    public function sender() {
        return $this->belongsTo(Staff::class, 'sender');
    }

    public function receiver() {
        return $this->belongsTo(Staff::class, 'receiver');
    }

    public function account() {
        return $this->belongsTo(Account::class, 'account');
    }

    public function app() {
        return $this->belongsTo(Discipline::class, 'app');
    }

    public function transaction() {
        return $this->belongsTo(Application::class, 'transaction');
    }
}
