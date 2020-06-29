<?php

namespace App\Models;

use App\Models\Traits\HasPrice;
use App\Models\Country;
use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    use HasPrice;

    public function countries()
    {
    	return $this->belongsToMany(Country::class);
    }
}
