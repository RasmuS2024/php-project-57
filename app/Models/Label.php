<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Label extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'label_task', 'label_id', 'task_id');
    }
}
