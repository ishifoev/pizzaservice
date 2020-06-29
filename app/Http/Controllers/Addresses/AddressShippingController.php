<?php

namespace App\Http\Controllers\Addresses;

use Illuminate\Http\Request;
use App\Models\Address;
use App\Http\Resources\ShippingMethodResource;
use App\Http\Controllers\Controller;

class AddressShippingController extends Controller
{
	public function __construct() {
		$this->middleware(['auth:api']);
	}
    public function action(Address $address)
    {
    	$this->authorize('show', $address);
       return ShippingMethodResource::collection($address->country->shippingMethods);
    }
}
