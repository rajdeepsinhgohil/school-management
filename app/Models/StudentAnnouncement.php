<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAnnouncement extends Model
{
    protected $fillable = [
        'title',
        'content',
        'teacher_id'
    ];
}
