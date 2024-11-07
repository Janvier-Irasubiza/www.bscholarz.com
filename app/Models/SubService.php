<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubService extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'name', 'description'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid();
            }
        });
    }

    public function plans()
    {
        return $this->belongsToMany(SubscriptionPlan::class, 'plan_services');
    }
}
