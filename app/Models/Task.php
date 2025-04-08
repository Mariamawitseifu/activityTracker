<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory, HasUuids, SoftDeletes;

    protected $guarded = [];

    protected $appends = ['sub_task_count', 'can_create_sub_task'];

    // protected $with = ['remarks'];

    protected $hidden = [
        'updated_at',
        'deleted_at',
    ];

    protected $statusMap = [
        0 => 'pending',
        1 => 'todo',
        2 => 'done',
        3 => 'blocked',
        4 => 'inprogress',
        5 => 'rejected',
    ];

    public function getStatusAttribute($value)
    {
        return $this->statusMap[$value];
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = array_search($value, $this->statusMap);
    }

    public static function getStatusMap()
    {
        return (new static)->statusMap;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function subTasks()
    {
        return $this->hasMany(SubTask::class, 'task_id', 'id');
    }

    public function getCanCreateSubTaskAttribute()
    {
        $taskDate = Carbon::parse($this->date)->startOfDay();
        $endOfRange = $taskDate->copy()->addDays(6)->endOfDay();

        return now()->between($taskDate, $endOfRange);
    }

    // public function remarks()
    // {
    //     return $this->morphMany(Remark::class, 'remarkable');
    // }

    // sub task count
    public function getSubTaskCountAttribute()
    {
        return $this->subTasks()->count();
    }
}
