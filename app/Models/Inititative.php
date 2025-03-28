<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inititative extends Model
{
    /** @use HasFactory<\Database\Factories\InititativeFactory> */
    use HasFactory,HasUuids, SoftDeletes;
    protected $guarded = [];
    public function objective()
    {
        return $this->belongsTo(Objective::class);
    }
}
