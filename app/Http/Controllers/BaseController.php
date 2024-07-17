<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendResponse($data = [], $message, $status, $code = 200)
    {
        $response = [
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'code' => $code,
        ];

        return response()->json($response);
    }
}
