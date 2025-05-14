<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
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
