<?php

namespace App\Services;

interface AccessCheckInterface
{
    function defineAccess();

    function check($permission, $params = []);
}
