<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

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
