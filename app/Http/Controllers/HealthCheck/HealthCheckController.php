<?php

declare(strict_types=1);

namespace App\Http\Controllers\HealthCheck;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

final class HealthCheckController
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(
            [
                'api-status' => 'ok',
            ],
            Response::HTTP_OK,
            ['Access-Control-Allow-Origin' => '*']
        );
    }
}
