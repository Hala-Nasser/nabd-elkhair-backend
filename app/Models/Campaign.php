<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     */
    protected $fillable = [
        'name',
        'description',
        'image',
        'expiry_date',
        'expiry_time',
        'donation_type_id',
        'charity_id'
    ];

    public function donation() {
        return $this->hasMany('App\Models\Donation');
    }
}
