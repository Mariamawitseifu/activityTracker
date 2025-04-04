<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitStatus extends Model
{
    /** @use HasFactory<\Database\Factories\UnitStatusFactory> */
    use HasFactory, HasUuids;

    protected $guarded = [];

    protected $hidden = [
        'updated_at',
        'deleted_at',
    ];

    /**
     * Get the unit that owns the EmployeeUnit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
