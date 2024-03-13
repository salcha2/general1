<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
    protected $table = 'admin_users';

    protected $fillable = [
        'username',
        'password',
        'name',
        'avatar',
        'remember_token',
        
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = [
        'created_at', 'updated_at', 'LAST_CONNECTION_DATE',
    ];
}
