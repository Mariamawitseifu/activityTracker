<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitType extends Model
{
    /** @use HasFactory<\Database\Factories\UnitTypeFactory> */
    use HasFactory, HasUuids, SoftDeletes;

    protected  $hidden = ['created_at', 'updated_at', 'deleted_at'];
    
}
