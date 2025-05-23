<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MainActivity extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function initiative()
    {
        return $this->belongsTo(Initiative::class, 'initiative_id');
    }

    public function measuringUnit()
    {
        return $this->belongsTo(MeasuringUnit::class);
    }
}
