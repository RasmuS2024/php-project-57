<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
{
    protected $fillable = [
        'name'
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
