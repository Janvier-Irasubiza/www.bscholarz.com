<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'discipline_id', 
        'applicant_id',
        'recommended_to',
        'comment', 
        'status',
    ];

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
