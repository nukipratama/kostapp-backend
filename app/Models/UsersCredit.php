<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersCredit extends Model
{
    use HasFactory;
    protected $table = 'users_credit';
    protected $fillable = ['credit'];

    public static function getDefaultUserCredit($userId)
    {
        $user = User::where('id', $userId)->with('role.detail')->first();
        return (int) config('credit.registration.reward.' . $user->role->detail->prefix, 0);
    }
}
