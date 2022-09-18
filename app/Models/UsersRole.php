<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersRole extends Model
{
    use HasFactory;
    protected $table = 'users_role';

    public function detail()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}
