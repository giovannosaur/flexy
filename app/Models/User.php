<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// app/Models/User.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public $incrementing = false; // karena ID custom
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'name', 'email', 'password', 'nik', 'status', 'position', 'role',
    ];

    protected $hidden = ['password', 'remember_token'];

    public function flexyRequests() {
        return $this->hasMany(FlexyRequest::class);
    }

    public function attendances() {
        return $this->hasMany(Attendance::class);
    }
}
