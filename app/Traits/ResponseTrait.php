<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait ResponseTrait
{
    public function responseJson($status, $message, $data=null)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ]);
    }//responsrJson
} // trait
