<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitManager extends Model
{

    protected $guarded = [];

    public function unitType()
    {
        return $this->belongsTo(UnitType::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
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
