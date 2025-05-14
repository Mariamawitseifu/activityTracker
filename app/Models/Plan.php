<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    /** @use HasFactory<\Database\Factories\PlanFactory> */
    use HasFactory, HasUuids, SoftDeletes;

    protected  $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = [];

    public function mainActivity()
    {
        return $this->belongsTo(MainActivity::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function parent()
    {
        return $this->belongsTo(Plan::class, 'parent_id');
    }

    public function planReports()
    {
        return $this->hasMany(PlanReport::class);
    }

    // subPlans
    public function subPlans()
    {
        return $this->hasMany(Plan::class, 'parent_id');
    }

    //fiscal year
    public function fiscalYear()
    {
        return $this->belongsTo(FiscalYear::class);
    }

    public function getTotalActualAttribute()
    {
        return $this->monitorings()->sum('actual_value');
    }


    /**
     * Get all of the monitorings for the Plan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    // public function monitorings(): HasMany
    // {
    //     return $this->hasMany(Monitoring::class, 'plan_id', 'id');
    // }

    public function monitorings()
{
    return $this->hasMany(Monitoring::class);
}

}
