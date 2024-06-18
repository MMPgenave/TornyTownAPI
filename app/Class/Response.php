<?php

namespace App\Class;

class Response
{

    public static function Success($Message , $Code = 200 , $Data = [])
    {
        return response()->json([
            'Status' => 'success',
            'Message' => $Message,
            'Code' => $Code,
            'Data' => $Data,
        ] , 200);
    }

    public static function Failed($Message , $Code = 400)
    {
        return response()->json([
            'Status' => 'failed',
            'Message' => $Message,
            'Code' => $Code,
        ] , 200);
    }

    public static function Error( $Code = 400 , $Errors)
    {
        return response()->json([
            'Status' => 'validation error',
            'Code' => $Code,
            'Errors' => $Errors
        ] , $Code);
    }

}
