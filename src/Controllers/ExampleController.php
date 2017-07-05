<?php

namespace jvleeuwen\broadsoft\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use jvleeuwen\broadsoft\Repositories\Contracts\BsExampleInterface;


class ExampleController extends Controller
{
    public function __construct(BsExampleInterface $bsExample)
    {
        $this->bsExample = $bsExample;
    }

    public function Agents($slug)
    {
        $data = array(
            'slug' => (string)$slug,
            'callcenters' => $this->bsExample->GetCallCentersBySlug($slug),
            'users' => $this->bsExample->GetUsersBySlug($slug),
        );
        return view('broadsoft::bs.example.agents', $data);
    }
}