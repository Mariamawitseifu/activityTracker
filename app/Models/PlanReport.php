<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanReport extends Model
{
    /** @use HasFactory<\Database\Factories\PlanReportFactory> */
    use HasFactory, HasUuids, SoftDeletes;

    protected  $hidden = ['created_at', 'updated_at', 'deleted_at', 'creator_id', 'plan_id'];

    protected $guarded = [];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
