<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
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
}
