<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'title',
        'content',
    ];
    public function teachers() {
        return $this->belongsToMany(User::class, 'teacher_announcements', 'id')->withPivot('is_read');
    }
}
