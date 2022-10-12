<?php
/**
 * API Handler
 * @package api
 * @version 0.0.2
 */

namespace Api\Library;

class Handler implements \Api\Iface\Response
{
    static function messageByError(int $code): string{
        $errors = [
            0   => 'OK',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            422 => 'Unprocessable Entity',
            500 => 'Internal Server Error',
            501 => 'Not Implemented'
        ];

        return $errors[$code] ?? 'Unknow';
    }

    static function resp($self, int $error=0, $data=null, string $message=null, array $meta=null): array{
        $result = [
            'error'   => $error,
            'message' => $message,
            'data'    => $data
        ];
        
        if($meta)
            $result = array_merge($result, $meta);

        $content = json_encode($result, JSON_PRESERVE_ZERO_FRACTION);

        return [$content, 'application/json'];
    }
}