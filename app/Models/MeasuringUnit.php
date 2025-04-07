<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MeasuringUnit extends Model
{
    /** @use HasFactory<\Database\Factories\MeasuringUnitFactory> */
    use HasFactory, HasUuids, SoftDeletes;

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function mainActivities()
    {
        return $this->hasMany(MainActivity::class);
    }
}
