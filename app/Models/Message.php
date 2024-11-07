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

    public function account() {
        return $this->belongsTo(Account::class, 'account');
    }

    public function user() {
        return $this->belongsTo(Applicant_info::class, 'user');
    }

    public function app() {
        return $this->belongsTo(Discipline::class, 'app');
    }

    public function transaction() {
        return $this->belongsTo(Application::class, 'request');
    }

    public function advert() {
        return $this->belongsTo(Advert::class, 'advert');
    }

    public function subscriber() {
        return $this->belongsTo(Subscriber::class, 'subscriber');
    }

    public function sub_plan() {
        return $this->belongsTo(SubPlan::class, 'sub_plan');
    }

    public function sub_service() {
        return $this->belongsTo(SubService::class, 'sub_service');
    }

    public function replies () {
        return $this->hasMany(MessageReply::class, 'message_id');
    }

}
