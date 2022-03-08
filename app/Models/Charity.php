<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Notifications\CharityPasswordResetNotification;
use App\Models\complaint;
use Illuminate\Database\Eloquent\SoftDeletes;

class Charity extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable ;
    use SoftDeletes;


    protected $table = "_charities";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function complaints(){
        return $this->hasMany(Complaint::class);
    }


}
