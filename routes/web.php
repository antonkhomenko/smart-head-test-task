<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return "Hello world";
});

Route::get("/widget", function() {
    return "Admin page";
});
