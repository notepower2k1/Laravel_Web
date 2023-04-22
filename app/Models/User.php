<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['lastLogin'];
    
    public function getLastLoginAttribute()
    {
        Carbon::setLocale('vi'); 

        $login = loginHistory::where('userID','=',$this->id)->orderBy('created_at', 'desc')->first();

        $dt = new Carbon($login->created_at);
        $now = Carbon::now();

        return $dt->diffForHumans($now);

    }
    public function profile() {
        return $this->hasOne(Profile::class,'userID');
    }

    public function books() {
        return $this->hasMany(Book::class,'userCreatedID','id');
    }

    public function documents() {
        return $this->hasMany(Document::class,'userCreatedID','id');
    }
}
