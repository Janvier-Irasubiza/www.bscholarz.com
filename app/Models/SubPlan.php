<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubPlan extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'name', 'price', 'duration_months', 'text'];

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
    return $this->hasManyThrough(
        SubService::class,         // Final model (target)
        PlanService::class,        // Intermediate model
        'plan_id',                // Foreign key on plan_services linking to sub_plans
        'id',                    // Foreign key on sub_services linking to plan_services
        'id',                     // Local key on sub_plans
        'service_id'        // Local key on plan_services
    );
}


    public function subscribers()
    {
        return $this->hasMany(SubscriberSubscription::class);
    }   
}
