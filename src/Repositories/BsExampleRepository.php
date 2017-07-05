<?php

namespace jvleeuwen\broadsoft\Repositories;

use jvleeuwen\broadsoft\Repositories\Contracts\BsExampleInterface;
use jvleeuwen\broadsoft\Database\Models\bsCallcenter;
use jvleeuwen\broadsoft\Database\Models\bsUserAssignedCallcenter;

class BsExampleRepository implements BsExampleInterface
{
    public function GetCallCentersBySlug($slug)
    {
        return bsCallcenter::where('slug', $slug)->get();
    }

    public function GetUsersBySlug($slug)
    {
        $callcenters = $this->GetCallCentersBySlug($slug);
        $userArray= array();
        foreach($callcenters as $callcenter)
        {
            $users = bsUserAssignedCallcenter::with('bsUser')->where('serviceUserID', $callcenter->userId)->get();
            array_push($userArray, $users);
        }
        return $userArray[0];
    }
}