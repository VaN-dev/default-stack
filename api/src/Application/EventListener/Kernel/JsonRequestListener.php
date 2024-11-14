<?php

namespace Application\EventListener\Kernel;

use InvalidArgumentException;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use JsonException;

/**
 * Sets a "_json_content" array into the Request attributes if a Request JSON raw body has been received.
 */
class JsonRequestListener
{
    /**
     * @throws JsonException
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        $requestContent = $request->getContent();
        if ($requestContent && in_array($requestContent[0], ['{', '[']) && 'json' === $request->getContentType()) {
            $requestDataArray = json_decode($requestContent, true, 512, JSON_THROW_ON_ERROR);
            if (null === $requestDataArray) {
                // JSON decoding failed: we have to tell the client.
                throw new InvalidArgumentException('Could not parse JSON input.');
            }
            $request->attributes->set('_json_content', $requestDataArray ?? []);
        }
    }
}
