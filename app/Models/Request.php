<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Request extends Model
{
    use HasFactory;

    protected $table = 'applications';
    protected $primaryKey = 'app_id';

    protected $fillable = [
        'app_id',
        'uuid',
        'applicant',
        'discipline_id',
        'request_time',
        'service_amount',
        'payment_status',
        'payment_id',
        'amount_paid',
        'outstanding_amount',
        'outstanding_payment_status',
        'outstanding_paid_amount',
        'assistant_pending_commission',
        'payment_date',
        'status',
        'deletion_status',
        'deleted_on',
        'review_ccl',
        'revied_by',
        'revied_on',
        'application_type',
        'username',
        'password',
        'link_to_dashboard',
        'postponing_reason',
        'observation',
        'assistant',
        'served_on',
        'amount_not_paid',
        'deliberation',
        'assistant_paid_commission',
        'remittance_status',
        'poked',
        'is_appointment',
        'address',
        'time',
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

    public function user() {
        return $this->belongsTo(Applicant_info::class, 'applicant');
    }

    public function discipline () {
        return $this->belongsTo(Discipline::class);
    }

    public function appAssistant() {
        return $this->belongsTo(Staff::class, 'assistant');
    }
}
