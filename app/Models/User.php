<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'username',
        'password',
        'role'
    ];
    
    protected $casts = [
        'username_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $primaryKey = 'id_user';
    public $incrementing = true;
    protected $keyType = 'int';

    public function savedPosts()
    {
        return $this->hasMany(SavedPost::class);
    }

    public function profilePicture()
{
    return $this->hasOne(ProfilePicture::class, 'id_user');
}


}
