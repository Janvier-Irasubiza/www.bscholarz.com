<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubPlan extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'duration_months'];

    public function services()
    {
        return $this->belongsToMany(Service::class, 'plan_services');
    }

    public function subscribers()
    {
        return $this->hasMany(SubscriberSubscription::class);
    }   
}
