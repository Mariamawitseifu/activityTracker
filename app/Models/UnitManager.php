<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitManager extends Model
{

    use HasUuids, HasFactory;
    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
    public function unitManager()
    {
        return $this->hasMany(UnitManager::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
}
