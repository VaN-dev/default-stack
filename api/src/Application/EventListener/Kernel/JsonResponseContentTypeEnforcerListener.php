<?php

namespace Application\EventListener\Kernel;

use Symfony\Component\HttpKernel\Event\ResponseEvent;

/**
 * Forces a "Content-Type: application/json" (or the one of the Request, if we have) for all our responses,
 * even when Symfony strips its (see Symfony's `Response#prepare()`).
 */
class JsonResponseContentTypeEnforcerListener
{
    public function onKernelResponse(ResponseEvent $event): void
    {
        $response = $event->getResponse();

        if (!$response->headers->has('Content-Type')) {
            $contentType = 'application/json';

            $request = $event->getRequest();
            $format = $request->getRequestFormat(null);
            if (null !== $format && $mimeType = $request->getMimeType($format)) {
                $contentType = $mimeType;
            }
            $response->headers->set('Content-Type', $contentType);
        }
    }
}
