<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    use HasFactory;

    // Specify the table name if it doesn't follow Laravel's conventions
    protected $table = 'disciplines'; // Change this if your table name is different

    // Specify the primary key if it's not 'id'
    protected $primaryKey = 'id'; // Change if necessary

    // Disable timestamps if your table doesn't have created_at and updated_at fields
    public $timestamps = false; // Set to true if your table has timestamps

    // Specify the fillable fields
    protected $fillable = [
        'identifier',
        'discipline_name',
        'organization',
        'country',
        'category',
        'discipline_desc',
        'discipline_detailed_desc',
        'poster',
        'includes',
        'requirements',
        'status',
        'mode',
        'service_fee',
        'start_date',
        'publish_date',
        'due_date',
        'speciality',
        'link',
        'website_link',
    ];

    // Define any relationships if needed
    // For example, if a Discipline has many Comments:
    public function comments()
    {
        return $this->hasMany(Comment::class); // Change Comment to your actual comment model name
    }
}
