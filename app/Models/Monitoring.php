<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Monitoring extends Model
{
    /** @use HasFactory<\Database\Factories\MonitoringFactory> */
    use HasFactory, HasUuids, SoftDeletes;

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'month' => 'date:M Y',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function fiscalYear()
    {
        return $this->belongsTo(FiscalYear::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
