<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Main extends Model
{
    /** @use HasFactory<\Database\Factories\MainFactory> */
    use HasFactory, HasUuids, SoftDeletes;
    protected $guarded = [];
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function initiative()
    {
        return $this->belongsTo(Inititative::class);
    }
}
