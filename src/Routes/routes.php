<?php

Route::group(['prefix' => 'bs'], function () {
    Route::post('CallCenterAgent', 'jvleeuwen\broadsoft\Controllers\CallCenterAgentController@Incomming'); // Handles all incomming XML for the Call Center Agent events.
    Route::post('CallCenterQueue', 'jvleeuwen\broadsoft\Controllers\CallCenterQueueController@Incomming'); // Handles all incomming XML for the Call Center Agent events.
    Route::post('AdvancedCall', 'jvleeuwen\broadsoft\Controllers\AdvancedCallController@Incomming'); // Handles all incomming XML for the Advanced Call events.

    Route::group(['prefix' => 'actions'], function () {
        // Route::get('getcallcenters', 'jvleeuwen\broadsoft\Controllers\ActionController@GetCallCenters');
        Route::get('getusers', 'jvleeuwen\broadsoft\Controllers\ActionController@GetUsers');
        Route::get('getusercallcenterservices','jvleeuwen\broadsoft\Controllers\ActionController@GetUserCallCenterServices');
    });

    Route::get('debug', 'jvleeuwen\broadsoft\Controllers\DebugController@Index');
    Route::group(['prefix' => 'debug'], function () {
        Route::get('callcenteragent', 'jvleeuwen\broadsoft\Controllers\DebugController@CallCenterAgentEvent');
        Route::get('callcenterqueue', 'jvleeuwen\broadsoft\Controllers\DebugController@CallCenterQueueEvent');
        Route::get('advancedcall', 'jvleeuwen\broadsoft\Controllers\DebugController@AdvancedCallEvent');
    });


    Route::group(['prefix' => 'example'], function () {
        Route::get('callcenter/{slug}', 'jvleeuwen\broadsoft\Controllers\ExampleController@Callcenter');
    });
});
