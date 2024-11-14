<?php

namespace Infrastructure\Http\Response\Presenter;

use Symfony\Component\HttpFoundation\Response;

/**
 * @codeCoverageIgnore
 * (this is a pretty trivial ValueObject)
 */
class EmptyResponsePresenter implements ResponseHttpStatusCodeProviderPresenter
{
    private int $statusCode;

    public function __construct(int $statusCode = Response::HTTP_NO_CONTENT)
    {
        $this->statusCode = $statusCode;
    }

    public function getHttpStatusCode(): int
    {
        return $this->statusCode;
    }
}
