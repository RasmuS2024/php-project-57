<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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

    public function status()
    {
        return $this->belongsTo(TaskStatus::class, 'status_id');
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class, 'label_task');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function assignee()
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
