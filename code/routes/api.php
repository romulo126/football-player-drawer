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
        Route::get('/', 'SoccerPlayerAllController');
        Route::post('store', 'StoreSoccerPlayerController');
        Route::post('update/{id}', 'UpdateSoccerPlayerController');
        Route::delete('delete/{id}', 'DeleteSoccerPlayerController');

        Route::group([
            'prefix' => 'search'
        ], function () {
            Route::get('confirmed', 'SoccerPlayerConfirmedController');
            Route::get('not/confirmed', 'SoccerPlayerNotConfirmedController');
        });
        
    });

    Route::group([
        'prefix' => 'team',
        'namespace' => 'Team',
    ], function () {
        Route::get('/', 'AllSoccerTeamController');
        Route::post('store', 'StoreSoccerTeamController');
        Route::post('update/{id}', 'UpdateSoccerTeamController');
        Route::delete('delete/{id}', 'DeleteSoccerTeamController');
        Route::get('last/draw', 'LastDrawSoccerTeamController');
        Route::get('draw', 'DrawSoccerTeamController');
    });
});