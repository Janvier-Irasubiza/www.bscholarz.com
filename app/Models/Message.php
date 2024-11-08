<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'issue',
        'sender',
        'receiver',
        'app',
        'request',
        'account',
        'user',
        'advert',
        'subscriber_id',
        'sub_plan_id',
        'sub_service_id',
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

    protected $casts = [
        'tags' => 'array',
    ];

    public function sender() {
        return $this->belongsTo(Staff::class, 'sender');
    }

    public function receiver() {
        return $this->belongsTo(Staff::class, 'receiver');
    }

    public function replies () {
        return $this->hasMany(MessageReply::class, 'message_id');
    }

}
