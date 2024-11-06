<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubPlan extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'name', 'price', 'duration_months'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid();
            }
        });
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'plan_services');
    }

    public function subscribers()
    {
        return $this->hasMany(SubscriberSubscription::class);
    }   
}
