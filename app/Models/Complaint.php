<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Complaint extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     */
    protected $fillable = [
        'complainer_id',
        'defendant_id',
        'complainer_type',
        'complaint_reason',
    ];

    protected $casts = [
        'complaint_reason' => 'array'
    ];

    public function donor() {
        return $this->belongsTo('App\Models\Donor','complainer_id','id');
    }
}
