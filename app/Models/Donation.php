<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'donor_id',
        'charity_id',
        'campaign_id',
        'donation_type_id',
        'donation_way',
        'payment_link_id',
        'donation_amount',
        'donor_phone',
        'donor_district',
        'donor_city',
        'donor_address'
    ];

    public function donor() {
        return $this->belongsTo('App\Models\Donor');
    }

    public function campaign() {
        return $this->belongsTo('App\Models\Campaign');
    }
}

