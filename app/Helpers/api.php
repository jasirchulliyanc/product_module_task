<?php

/**
 * function to return api response
 * @param  boolean  $status
 * @param  integer  $status_code
 * @param  mixed  $data
 * @param  mixed  $error_message
 * @param  mixed  $validation_error
 */

use App\Models\BookingTransaction;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

if (!function_exists('response_data')) {
    function response_data($status, $status_code, $data = null, $message = null, $validation_error = null)
    {
        if ($status) {
            return response()->json([
                'Response' => [
                        'status' => $status,
                    ] + ($data ? [
                        'result' => $data,
                    ] : []) + ($message ? [
                        'message' => $message,
                    ] : [])
            ], $status_code);
        } else {
            return response()->json([
                'Response' => [
                        'status' => $status,
                        'message' => $message,
                    ] + ($validation_error ? [
                        'error' => $validation_error,
                    ] : []),
            ], $status_code);
        }
    }
}

