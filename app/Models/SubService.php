<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubService extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function plans()
    {
        return $this->belongsToMany(SubscriptionPlan::class, 'plan_services');
    }
}
