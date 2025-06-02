<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'name',
        'task_id'
    ];

    public function statuses(): HasMany
    {
        return $this->hasMany(TaskStatus::class);
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class);
    }
}
