<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Scopes\TokenScope;

class Token extends Model
{
    use HasFactory, TokenScope;

    protected $fillable = [
        'permission_id',
        'token',
        'model_id',
        'model_name',
        
        'expired_at'
    ];

    protected $casts = [
        'model_name' => 'array',
        'expired_at' => 'datetime',
    ];
}
