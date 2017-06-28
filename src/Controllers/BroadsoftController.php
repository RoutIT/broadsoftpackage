<?php

namespace jvleeuwen\broadsoft;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BroadsoftController extends Controller
{
    public function TestPage()
    {
    	return view('broadsoft::testpage');
    }
}
//  Deze controller komt te vervallen.
