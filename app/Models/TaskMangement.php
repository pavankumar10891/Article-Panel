<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskMangement extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_user_id',
        'assign_user_id',
        'title',
        'keyword',
        'word_count',
        'guideline',
        'content',
        'priority'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'created_user_id');
    }

    public function writer(){
        return $this->belongsTo(User::class, 'assign_user_id');
    }

    public function article(){
        return $this->hasOne(Article::class, 'task_mangement_id');
    }
}
