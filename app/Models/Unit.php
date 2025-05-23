<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    /** @use HasFactory<\Database\Factories\UnitFactory> */
    use HasFactory, HasUuids, SoftDeletes;

    protected  $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = [];
    protected $casts = [
        'is_main' => 'boolean',
    ];

    public function unitType()
    {
        return $this->belongsTo(UnitType::class);
    }

    public function manager()
    {
        return $this->hasOne(UnitManager::class);
    }

    public function parent()
    {
        return $this->belongsTo(Unit::class, 'parent_id');
    }
}
