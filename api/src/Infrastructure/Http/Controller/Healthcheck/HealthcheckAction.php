<?php

namespace Infrastructure\Http\Controller\Healthcheck;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class HealthcheckAction
{
    public function __invoke(): JsonResponse
    {
        sleep(1);

        return new JsonResponse(['status' => Response::HTTP_OK]);
    }
}
