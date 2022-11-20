<?php

use App\Http\Controllers\Api\SearchCustomer;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('searchCustomers', SearchCustomer::class);
});
