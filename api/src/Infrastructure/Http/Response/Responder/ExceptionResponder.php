<?php

namespace Infrastructure\Http\Response\Responder;

use Symfony\Component\HttpFoundation\Response;
use Throwable;

interface ExceptionResponder
{
    public function __invoke(Throwable $exception): Response;
}
