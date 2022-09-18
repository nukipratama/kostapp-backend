<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersCredit extends Model
{
    use HasFactory;
    protected $table = 'users_credit';

    public static function getDefaultUserCredit($userId)
    {
        $user = User::where('id', $userId)->with('role.detail')->first();
        switch ($user->role->detail->prefix) {
            case 'regular_user':
                return 20;
            case 'premium_user':
                return 40;
            default:
                return 0;
        }
    }
}
