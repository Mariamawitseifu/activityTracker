<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasFactory;
    use HasUuids;
    
    protected $connection = 'mysql2';
    protected $primaryKey = 'uuid';
    
    protected $hidden = [
        'pivot',
        'guard_name',
        'created_at',
        'updated_at',
    ];
    
}
