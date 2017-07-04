<?php

namespace jvleeuwen\broadsoft\Repositories\Contracts;

interface BsExampleInterface
{
    function GetCallCentersBySlug($slug);
    function GetUsersBySlug($slug);
} 