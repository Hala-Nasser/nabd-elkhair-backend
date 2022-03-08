<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

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
}
