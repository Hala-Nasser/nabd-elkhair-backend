<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Charity;

class DonationType extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function donationType(){
        return $this->belongsToMany(Charity::class,'charity_donationType','donationType_id','charity_id');
    }
}
