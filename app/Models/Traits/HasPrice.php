<?php

namespace App\Models\Traits;

use App\Cart\Money;
use NumberFormatter;
use Money\Formatter\IntlMoneyFormatter;
use Money\Currencies\ISOCurrencies;
use Money\Currency;

trait HasPrice {
	  public function getPriceAttribute($value)
     {
        return new Money($value);
     }
     public function getFormattedPriceAttribute()
     {
         return $this->price->formatted();
     }
}