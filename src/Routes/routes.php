<?php

Route::group(['prefix' => 'bs'], function () {
    Route::get('testpage', 'jvleeuwen\broadsoft\BroadsoftController@TestPage'); // Just a simple test page to check if the packages is loaded.
    Route::get('callcenteragent', 'jvleeuwen\broadsoft\CallcenterAgentController@TestPage'); // Call Center Agent Test page.
    Route::get('pusher', 'jvleeuwen\broadsoft\EventController@TestEvent');
    Route::post('CallCenterAgent', 'jvleeuwen\broadsoft\CallCenterAgentController@Incomming'); // Handles all incomming XML for the Call Center Agent events.
    Route::post('AdvancedCall', 'jvleeuwen\broadsoft\AdvancedCallController@Incomming'); // Handles all incomming XML for the Advanced Call events.


    Route::group(['prefix' => 'examples'], function () {
    	Route::get('callcenteragent', 'jvleeuwen\broadsoft\Controllers\ExampleController@CallCenterAgent');
    });
});
