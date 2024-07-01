<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'number_of_license',
        'time_period',
        'payment_mode',
        'plan_type',
        'payment_amount',
    ];

    public function customer(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function plan(){
        return $this->belongsTo(Package::class, 'plan_id');
    }
    public function licences(){
        return $this->hasMany(License::class, 'order_id');
    }
    public function totalActivelicences(){
        return $this->hasMany(License::class, 'order_id')->where('is_active',1);
    }
    public function totalInactivelicences(){
        return $this->hasMany(License::class, 'order_id')->where('is_active',0);
    }
}
