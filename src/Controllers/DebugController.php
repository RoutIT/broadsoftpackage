<?php

namespace jvleeuwen\broadsoft\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DebugController extends Controller
{
    public function CallCenterAgentEvent()
    {
    	return view('broadsoft::bs.debug.callcenteragent');
    }

    public function CallCenterQueueEvent()
    {
        return view('broadsoft::bs.debug.callcenterqueue');
    }

    public function AdvancedCallEvent()
    {
        return view('broadsoft::bs.debug.advancedcall');
    }
}