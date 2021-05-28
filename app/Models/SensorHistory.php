<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorHistory extends Model
{
    use HasFactory;

    protected $fillable = ['serial_number', 'temperature', 'humidity', 'voltage', 'current', 'power'];
}
