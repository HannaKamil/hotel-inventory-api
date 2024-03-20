<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Response;

class Reply
{
    public static function message($data = [], $message = '', $status = true, $code = 200)
    {
        if (count($data) == 0) {
            $message = 'No data found';
            $status = false;
            $code = 404;
        }

        return response()->json([
            'code' => $code,
            'message' => $message,
            'status' => $status,
            'data' => $data ?? [],
        ], $code);
    }
}
