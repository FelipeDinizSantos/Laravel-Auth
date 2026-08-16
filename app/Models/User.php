<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as AuthUser;

class User extends AuthUser
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'username',
        'password',
        'token',
        'email',
        'active',
        'email_verified_at',
        'last_login_at',
        'blocked_until'
    ];

    protected $hidden = [
        'password',
        'token'
    ];

    protected $casts = [
        'active' => 'boolean',
    ];
}
