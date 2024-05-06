<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'App\Http\Controllers\Api',
    'prefix' => 'soccer'
], function () {
    Route::group([
        'prefix' => 'player',
        'namespace' => 'Player',
    ], function () {
        Route::post('store', 'StoreSoccerPlayerController');
        Route::post('update/{id}', 'UpdateSoccerPlayerController');
        Route::delete('delete/{id}', 'DeleteSoccerPlayerController');
    });

    Route::group([
        'prefix' => 'team',
        'namespace' => 'Team',
    ], function () {
        Route::post('store', 'StoreSoccerTeamController');
        Route::post('update/{id}', 'UpdateSoccerTeamController');
        Route::delete('delete/{id}', 'DeleteSoccerTeamController');
        Route::get('/', 'AllSoccerTeamController');
        Route::get('draw', 'DrawSoccerTeamController');
    });
});