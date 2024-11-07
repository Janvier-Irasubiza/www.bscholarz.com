<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'discipline_id', 
        'applicant_id',
        'recommended_to',
        'comment', 
        'status',
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

    public function discipline()
    {
        return $this->belongsTo(Discipline::class);
    }

    public function user()
    {
        return $this->belongsTo(Applicant_info::class, 'applicant_id');
    }

    public function replies()
    {
        return $this->hasMany(CommentReply::class, 'comment_id');
    }

    public function admin() {
        return $this->belongsTo(Staff::class, 'recommended_to');
    }

}
