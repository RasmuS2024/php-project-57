<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status_id',
        'assigned_to_id',
        'created_by_id'
    ];

    public function status(): BelongsTo
    {
        return $this->belongsTo(TaskStatus::class, 'status_id');
    }

    public function labels(): BelongsToMany
    {
        return $this->belongsToMany(Label::class, 'label_task', 'task_id', 'label_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }

    public function scopeFilter($query, array $filters)
    {
        if ($filters['filter']['status_id'] ?? false) {
            $query->where('status_id', $filters['filter']['status_id']);
        }

        if ($filters['filter']['created_by_id'] ?? false) {
            $query->where('created_by_id', $filters['filter']['created_by_id']);
        }

        if ($filters['filter']['assigned_to_id'] ?? false) {
            $query->where('assigned_to_id', $filters['filter']['assigned_to_id']);
        }
    }
}
