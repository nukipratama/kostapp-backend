<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kost extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'location', 'price', 'description', 'is_available'];
    protected $hidden = ['description', 'is_available'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
