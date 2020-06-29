<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Transaction;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
        'total' => 1000
    ];
});
