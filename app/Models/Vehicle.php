<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['user_id','plate_number'];

    public function parkings(){
        return $this->hasMany(Parking::class,'parking_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
