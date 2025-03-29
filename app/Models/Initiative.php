<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Initiative extends Model
{
    /** @use HasFactory<\Database\Factories\InitiativeFactory> */
    use HasFactory,HasUuids, SoftDeletes;
    
    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function objective()
    {
        return $this->belongsTo(Objective::class);
    }
}
