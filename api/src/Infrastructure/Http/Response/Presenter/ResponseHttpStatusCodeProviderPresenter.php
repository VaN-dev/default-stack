<?php

namespace Infrastructure\Http\Response\Presenter;

/**
 * If a Presenter implements that interface our GenericSerializableResponder will get the HTTP status code from its
 * `getHttpStatusCode()` instead of just replying with a HTTP_OK status.
 */
interface ResponseHttpStatusCodeProviderPresenter
{
    public function getHttpStatusCode(): int;
}
