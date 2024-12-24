<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        "uuid",
        "applicant_id",
        "application_id",
        "amount",
        "status",
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

    public function customer()
    {
        return $this->belongsTo(Applicant_info::class);
    }

    public function application()
    {
        return $this->belongsTo(Request::class);
    }
}
