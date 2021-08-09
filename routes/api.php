<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// All of this routes are prefixed by '/api' ; exempled : 'http://localhost:8000/api/...'

    // Client routes
    Route::post('/createClient','ClientController@createClient');
    Route::put('/{CIN}/updateClient','ClientController@updateClient');
    Route::get('/{CIN}/getClient','ClientController@getClient');
    Route::get('/getAllClients','ClientController@getAllClients');
    Route::get('/{CIN}/getAccountBalance','ClientController@getAccountBalance');
