<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubTask extends Model
{
    /** @use HasFactory<\Database\Factories\SubTaskFactory> */
    use HasFactory, HasUuids, SoftDeletes;

    protected $guarded = [];

    // protected $with = ['remarks'];

    protected $hidden = [
        'updated_at',
        'deleted_at',
    ];

    protected $statusMap = [
        1 => 'todo',
        2 => 'done',
    ];

    public function getStatusAttribute($value)
    {
        return $this->statusMap[$value];
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = array_search($value, $this->statusMap);
    }

    public function parent()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }

    public static function getStatusMap()
    {
        return (new static)->statusMap;
    }

    public function remarks()
    {
        return $this->morphMany(Remark::class, 'remarkable');
    }
    // public function remarks()
    // {
    //     return $this->morphMany(Remark::class, 'remarkable');
    // }

    /**
     * Get the task that owns the EmployeeSubTask
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }
}
