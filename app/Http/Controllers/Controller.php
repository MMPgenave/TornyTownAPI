<?php

namespace App\Http\Controllers;

use App\Class\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Http\FormRequest;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function GetRandNumber()
    {
        return rand(1000000 , 1000000000000000000);
    }

}
