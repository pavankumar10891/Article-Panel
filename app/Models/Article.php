<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_mangement_id',
        'title',
        'article',
        'meta_title',
        'meta_keyword',
        'meta_desc',
        'status',
        'created_by',
        'updated_by',
        'finalsubmit'
    ];


    public function task(){
        return $this->belongsTo(TaskMangement::class,'task_mangement_id');
    }

}
