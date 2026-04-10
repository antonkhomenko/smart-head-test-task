<?php

use App\Http\Controllers\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::post('/tickets', [TicketController::class, 'store']);
Route::get('/tickets', [TicketController::class, 'index']);

Route::get('/customers', function (Request $request) {
    $requestedID = $request->query('id');
    dump($requestedID);
    echo "Requested id " . ( $requestedID ?? "Not provided" );
});
