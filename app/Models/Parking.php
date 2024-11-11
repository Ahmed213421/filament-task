<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','vehicle_id','zone_id','start_time','stop_time','price'];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function zone(){
        return $this->belongsTo(Zone::class,'zone_id');
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class,'vehicle_id');
    }
}
