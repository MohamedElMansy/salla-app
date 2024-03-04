<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ResponseHelper
{
    public static function successResponse($data, $code = ResponseAlias::HTTP_OK): JsonResponse
    {
        return response()->json(['data' => $data, 'code' => $code], $code);
    }

    public static function errorResponse($error, $code = ResponseAlias::HTTP_BAD_REQUEST, $key = ''): JsonResponse
    {
//      in production mode
//      $message = 'Something went wrong you can try later';
        // in development mode
        if (is_array($error)) {
            foreach ($error as $value) {
                if ($message) {
                    $message .= ', ';
                }
                $message .= (is_array($value) ? $value[0] : $value);
            }
        } else {
            $message = $error;
        }

        $output = ['error' => $message, 'code' => $code];
        if ($key) {
            $output['key'] = $key;
        }
        return response()->json($output, $code);
    }
}
