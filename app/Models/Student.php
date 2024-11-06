<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name',
        'email',
        'standard',
        'teacher_id',
        'parent_id'
    ];
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id','id');
    }
    public function parent()
    {
        return $this->belongsTo(StudentParent::class, 'parent_id','id');
    }
}
