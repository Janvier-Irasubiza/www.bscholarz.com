<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MessageReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'message_id',
        'user_id',
        'reply',
        'attachement',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid();
            }
        });
    }

    public function message() {
        return $this->belongsTo(Message::class);
    }

    public function user() {
        return $this->belongsTo(Staff::class);
    }

}
