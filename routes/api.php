<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api'], function ($router) {

    Route::group(['prefix' => 'auth'], function ($router) {

        Route::post('login', 'API\AuthController@login');
        Route::post('logout', 'API\AuthController@logout');
        Route::post('refresh', 'API\AuthController@refresh');
        Route::post('me', 'API\AuthController@me');

    });

    Route::apiResource('customer', 'API\CustomerController')->only(['store']);
    Route::apiResource('transaction', 'API\TransactionController')->except(['index']);

    Route::get('transaction/{customerId}/{transactionId}', 'API\TransactionController@showGet');

    Route::post('transactions', 'API\TransactionController@filterPost');

    Route::get('transactions/{customerId}/{amount?}/{date?}/{offset?}/{limit?}', 'API\TransactionController@filterGet')
        ->where([
                'customerId' => '[0-9]+',
                'amount' => '([0-9]*[.])?[0-9]+',
                'date' => '([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))',
                'offset' => '[0-9]+',
                'limit' => '[0-9]+'
            ]
        );

});
