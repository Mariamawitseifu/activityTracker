<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitManager extends Model
{

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function unitType()
    {
        return $this->belongsTo(UnitType::class);
    }

    public function unit()
    {
        return $this->hasMany(Unit::class);
    }
    public function unitManager()
    {
        return $this->hasMany(UnitManager::class);
    }
    
}
