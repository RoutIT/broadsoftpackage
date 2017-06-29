<?php

Route::group(['prefix' => 'bs'], function () {
    Route::post('CallCenterAgent', 'jvleeuwen\broadsoft\CallCenterAgentController@Incomming'); // Handles all incomming XML for the Call Center Agent events.
    Route::post('CallCenterQueue', 'jvleeuwen\broadsoft\CallCenterQueueController@Incomming'); // Handles all incomming XML for the Call Center Agent events.
    Route::post('AdvancedCall', 'jvleeuwen\broadsoft\AdvancedCallController@Incomming'); // Handles all incomming XML for the Advanced Call events.


    Route::group(['prefix' => 'debug'], function () {
        Route::get('callcenteragent', 'jvleeuwen\broadsoft\Controllers\DebugController@CallCenterAgentEvent');
        Route::get('callcenterqueue', 'jvleeuwen\broadsoft\Controllers\DebugController@CallCenterQueueEvent');
        Route::get('advancedcall', 'jvleeuwen\broadsoft\Controllers\DebugController@AdvancedCallEvent');
    });
});
