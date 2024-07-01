<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;
use Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'user_name',
        'email',
        'password',
        'mobile', 
        'address',               
        'designation',   
        'ppw', 
        'bio',  
        'expert_niche',   
        'daily_capecity',       
        'experience',    
        'image', 
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function order(){
        return $this->belongsToMany(Order::class, 'user_id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->user_name = Str::slug($model->name);
            $model->user_name = static::generateUniqueUsername($model->user_name);
        });
    }

    public static function generateUniqueUsername($username)
    {
        $original = $username;
        $count = 1;

        while (static::where('user_name', $username)->exists()) {
            $username = $original . '-' . $count++;
        }
        return $username;
    }

    public function writerTask(){
        return $this->hasMany(TaskMangement::class, 'assign_user_id')->whereIn('status', [0,1,4]);
    }
    public function countWriterTask(){
        return $this->writerTask()->whereIn('status', [0,1,4])->count();
    }


}
