<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function validarCodigoHttp(int $codigoHttp): bool
    {
        $codigosValidos = [
            100, 101, 102, 103,// 1xx Informational
            200, 201, 202, 203, 204, 205, 206, 207, 208, 226,// 2xx Success  
            300, 301, 302, 303, 304, 305, 307, 308,// 3xx Redirection
            400, 401, 402, 403, 404, 405, 406, 407, 408, 409, 410, 411, 412, 413, 414, 415, 416, 417, 418, 421, 422, 423, 424, 425, 426, 428, 429, 431, 451,// 4xx Client Error
            500, 501, 502, 503, 504, 505, 506, 507, 508, 510, 511// 5xx Server Error
        ];

        if (in_array($codigoHttp, $codigosValidos)) {
            return true;
        }

        return false;
    }
}
