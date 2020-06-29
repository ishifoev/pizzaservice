<?php

namespace App\Http\Controllers\PaymentMethods;

use Illuminate\Http\Request;
use App\Cart\Payments\Gateway;
use App\Http\Resources\PaymentMethodResource;
use App\Http\Requests\PaymentMethods\PaymentMethodStoreRequest;
use App\Http\Controllers\Controller;

class PaymentMethodController extends Controller
{
	public function __construct(Gateway $gateway)
    {
    	$this->middleware(['auth:api']);
    	$this->gateway = $gateway;
    }
    
    public function index(Request $request)
    {
    	return PaymentMethodResource::collection($request->user()->paymentMethods);
    }

    public function store(PaymentMethodStoreRequest $request)
    {
    	
    	$card = $this->gateway->withUser($request->user())
    	                      ->createCustomer()
    	                      ->addCard($request->token);

    	return new PaymentMethodResource($card);
    }
}
