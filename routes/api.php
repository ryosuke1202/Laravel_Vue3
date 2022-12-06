<?php

use App\Http\Controllers\Api\AnalysisController;
use App\Http\Controllers\Api\SearchCustomer;
use Illuminate\Support\Facades\Route;   

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('searchCustomers', SearchCustomer::class)->name('api.searchCustomers');
    Route::get('analysis', AnalysisController::class)->name('api.analysis');
});
