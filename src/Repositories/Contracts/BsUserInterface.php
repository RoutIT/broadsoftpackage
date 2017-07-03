<?php

namespace jvleeuwen\broadsoft\Repositories\Contracts;

interface BsUserInterface
{
    function SaveToDB($UserArray);
    function UserdbCompare($bsArray);
} 