<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{
    public function sendRespose(array $result, string $message, int $code = Response::HTTP_OK)
    {
        $response = [
            'sucess' => true,
            'message' => $message,
            'data' => $result
        ];

        return response()->json($response, $code);
    }

    public function sendError(array $message, array $errorMessage, int $code = Response::HTTP_NOT_FOUND)
    {
        $response = [
            'sucess' => false,
            'message' => $message,
            'data' => []
        ];

        if (!empty($errorMessage)) {
            $response['errors'] = $errorMessage;
        }

        return response()->json($response, $code);
    }
}
