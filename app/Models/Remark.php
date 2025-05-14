<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Remark extends Model
{
    /** @use HasFactory<\Database\Factories\RemarkFactory> */
    use HasFactory, HasUuids, SoftDeletes;

    protected  $hidden = ['created_at', 'updated_at', 'deleted_at', 'remarkable_id', 'remarkable_type'];

    protected $guarded = [];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function remarkable()
    {
        return $this->morphTo();
    }
}
