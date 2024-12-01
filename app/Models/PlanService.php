<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Model;

class PlanService extends Pivot
{

    protected $table = 'plan_services';

    use HasFactory;

    // public function 
}
