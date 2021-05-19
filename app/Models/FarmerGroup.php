<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class FarmerGroup extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'chairman', 'year_formed', 'address', 'number_of_members', 'latitude', 'longitude'];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
