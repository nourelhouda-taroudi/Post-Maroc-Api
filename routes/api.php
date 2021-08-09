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

    // Credit routes
    Route::post('/applyForCredit/{CIN}','CreditController@createCredit');
    Route::get('/{idCredit}/getCredit','CreditController@getCredit');
    Route::put('/{idCredit}/updateCredit','CreditController@updateCredit');
    Route::get('/getAllCredits','CreditController@getAllCredits'); // 2 cas =>1:getAll for all client 2:getAll for specific client
    Route::post('/sign','CreditController@sign');

    // Document routes
    Route::post('/uploadDocument','DocumentController@storeDocument');
    Route::get('/{id}/getDocument','DocumentController@getDocument'); // get document for specific client
    Route::put('/{id}/updateDocument','DocumentController@updateDocument');
    Route::get('/getAllDocuments','DocumentController@getAllDocuments'); // 2 cas =>1:getAll for all client 2:getAll for specific client
