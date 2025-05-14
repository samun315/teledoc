<?php

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

// Date converted form to database
if (!function_exists('dateConvertFormToDB')) {
    function dateConvertFormToDB($date)
    {
        if (!empty($date)) {
            return date("Y-m-d", strtotime(str_replace('/', '-', $date)));
        }
    }
}

// Date converted form to database
if (!function_exists('dateTimeConvertFormToDB')) {
    function dateTimeConvertFormToDB($date)
    {
        if (!empty($date)) {
            return date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $date)));
        }
    }
}

// Date converted database to form or others
if (!function_exists('dateConvertDBToForm')) {
    function dateConvertDBToForm($date)
    {
        if (!empty($date)) {
            $date = strtotime($date);
            return date('d/m/Y', $date);
        }
    }
}

// Created at date converted to database
if (!function_exists('createdAtDateConvertToDB')) {
    function createdAtDateConvertToDB(): string
    {
        return date('Y-m-d H:i:s', strtotime(Carbon::now()));
    }
}

// Get logged in user id
if (!function_exists('loggedInUserId')) {
    function loggedInUserId(): int
    {
        return session('logged_session_data.id');
    }
}

if (!function_exists('sendSuccessResponse')) {
    function sendSuccessResponse(
        int $statusCode,
        string $message,
        ?string $keyOfData = null,
        $data = null
    ): JsonResponse {
        $responseResult = [
            'success' => true,
            'statusCode' => $statusCode,
            'message' => $message,
        ];

        if (!empty($keyOfData) && !empty($data)) {
            $responseResult[$keyOfData] = $data;
        } elseif (empty($keyOfData) && !empty($data)) {
            // Assuming $data is an array to be merged into the response
            if (is_array($data)) {
                $responseResult = array_merge($responseResult, $data);
            } else {
                $responseResult['data'] = $data; // Handle non-array data
            }
        }

        return response()->json($responseResult, $statusCode);
    }
}

if (!function_exists('sendErrorResponse')) {
    function sendErrorResponse(string $message, string|array $errorMessages, int $statusCode = 404): JsonResponse
    {
        $response = [
            'success' => false,
            'statusCode' => $statusCode,
            'message' => $message,
        ];

        if (!empty($errorMessages)) {
            $response['errors'] = $errorMessages;
        }

        return response()->json($response, $statusCode);
    }
}


if (!function_exists('getLoggedInUserInfo')) {
    function getLoggedInUserInfo($key)
    {
        return session($key);
    }
}


