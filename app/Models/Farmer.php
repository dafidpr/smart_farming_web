<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Farmer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['farmer_group_id', 'username', 'password', 'name', 'gender', 'phone', 'email', 'birthplace', 'birthday', 'land_area', 'serial_number', 'block', 'status'];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
