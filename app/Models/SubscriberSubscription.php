<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriberSubscription extends Model
{
    use HasFactory;

    protected $fillable = ['subscriber_id', 'plan_id', 'start_date', 'end_date', 'is_active'];

    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }
}
