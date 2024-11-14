<?php

namespace Infrastructure\Http\Response\Presenter;

/**
 * If a Presenter implements that interface our GenericSerializableResponder will add the given HTTP headers from its
 * `getHttpHeaders()` on top of the other ones.
 */
interface ResponseHttpHeadersProviderPresenter
{
    public function getHttpHeaders(): array;
}
