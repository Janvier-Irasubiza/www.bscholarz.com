<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubscriberSubscription extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'subscriber_id', 'plan_id', 'start_date', 'end_date', 'is_active', 'transaction_id', 'amount'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid();
            }
        });
    }

    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }

    public function plan()
    {
        return $this->belongsTo(SubPlan::class);
    }
}
