<?php

namespace jvleeuwen\broadsoft\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function CallCenterAgent()
    {
    	return view('broadsoft::bs.examples.callcenteragent');
    }
}

