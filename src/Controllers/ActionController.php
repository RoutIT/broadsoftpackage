<?php

namespace jvleeuwen\broadsoft\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class ActionController extends Controller
{
    private function RequestInit()
    {
       $client = new Client([
            'base_uri' => 'https://'. env('BS_XSI_HOST'),// Base URI is used with relative requests
            'timeout'  => 2.0, // You can set any number of default request options.
        ]); 
        return $client;
    }

    private function RequestAction($cmd, $startIndex=1)
    {
        $uri = '/'.env('BS_ACTION_PREFIX').'/v2.0/user/'.env('BS_QRY_USER').'@'.Str::lower(env('BS_GROUP')).'.'.env('BS_FQDN'). $cmd .'&start='.$startIndex;
        return $uri;
            
    }

    private function RequestEvent($cmd)
    {
        $uri = '/'.env('BS_EVENT_PREFIX').'/v2.0/user/'.env('BS_QRY_USER').'@'.Str::lower(env('BS_GROUP')).'.'.env('BS_FQDN'). $cmd; 
        return $uri;
            
    }

    private function RequestResponse($base, $uri)
    {
        $response = $base->request('GET', $uri, ['auth' => [
                env('BS_ADMIN_USER'), 
                env('BS_ADMIN_PASS')
        ]]);
        return $response;
    }

    public function GetCallCenters()
    {
        $userArray = array();
        $base = $this->RequestInit();
        $uri = $this->RequestAction('/directories/group?format=json&firstName=Call%20Center'); // This request gets only callcenters bases on the Firstname
        $response = $this->RequestResponse($base,$uri);
        $data = json_decode($response->getBody(), true);
        $startIndex = $data['Group']['startIndex']['$'];
        $numberOfRecords = $data['Group']['numberOfRecords']['$'];
        $totalAvailableRecords = $data['Group']['totalAvailableRecords']['$'];
        $parsedRecords = $startIndex+$numberOfRecords;
        $users = $data['Group']['groupDirectory']['directoryDetails'];
        foreach($users as $user)
        {
            array_push($userArray, $user);
        }

        while($parsedRecords <= $totalAvailableRecords){ 
            $base = $this->RequestInit();
            $uri = $this->RequestAction('/directories/group?format=json', $parsedRecords);
            $response = $this->RequestResponse($base,$uri);
            $data = json_decode($response->getBody(), true);
            $startIndex = $data['Group']['startIndex']['$'];
            $numberOfRecords = $data['Group']['numberOfRecords']['$'];
            $totalAvailableRecords = $data['Group']['totalAvailableRecords']['$'];
            $users = $data['Group']['groupDirectory']['directoryDetails'];
            foreach($users as $user)
            {
                array_push($userArray, $user);
            }
            $parsedRecords +=$numberOfRecords;
        }
        return response()->json($userArray);
    }

    public function GetAllUsers()
    {
        $blacklist = explode(',', env('BS_USER_BLACKLIST'));
        $accepted_domains = explode(',',env('BS_ACCEPTED_DOMAINS'));
        $userArray = array();
        $callCenterArray = array();
        $base = $this->RequestInit();
        $uri = $this->RequestAction('/directories/group?format=json'); // Gets all users from the group directory
        $response = $this->RequestResponse($base,$uri);
        $data = json_decode($response->getBody(), true);
        $startIndex = $data['Group']['startIndex']['$'];
        $numberOfRecords = $data['Group']['numberOfRecords']['$'];
        $totalAvailableRecords = $data['Group']['totalAvailableRecords']['$'];
        $parsedRecords = $startIndex+$numberOfRecords;
        $users = $data['Group']['groupDirectory']['directoryDetails'];
        foreach($users as $user)
        {   
            if(!in_array($user['userId']['$'], $blacklist))
            {
                foreach($accepted_domains as $domain)
                {
                    if(str_contains($user['userId']['$'], $domain))
                    {
                        if($user['firstName']['$'] == "Call Center")
                        {
                            if(isset($user['additionalDetails']['department']))
                            {
                                array_push($callCenterArray, $user);
                            }
                        }
                        else
                        {
                            if(isset($user['additionalDetails']['department']))
                            {
                                array_push($userArray, $user);
                            }
                        }
                    }
                }   
            }
        }

        while($parsedRecords <= $totalAvailableRecords){ 
            $base = $this->RequestInit();
            $uri = $this->RequestAction('/directories/group?format=json', $parsedRecords);
            $response = $this->RequestResponse($base,$uri);
            $data = json_decode($response->getBody(), true);
            $startIndex = $data['Group']['startIndex']['$'];
            $numberOfRecords = $data['Group']['numberOfRecords']['$'];
            $totalAvailableRecords = $data['Group']['totalAvailableRecords']['$'];
            $users = $data['Group']['groupDirectory']['directoryDetails'];
            foreach($users as $user)
            {   
                if(!in_array($user['userId']['$'], $blacklist))
                {
                    foreach($accepted_domains as $domain)
                    {
                        if(str_contains($user['userId']['$'], $domain))
                        {
                            if($user['firstName']['$'] == "Call Center")
                            {
                                if(isset($user['additionalDetails']['department']))
                                {
                                    array_push($callCenterArray, $user);
                                }
                            }
                            else
                            {
                                if(isset($user['additionalDetails']['department']))
                                {
                                    array_push($userArray, $user);
                                }
                            }
                        }
                    }   
                }
            }
            $parsedRecords +=$numberOfRecords;
        }
        return response()->json($userArray);
    }
}