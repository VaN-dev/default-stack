<?php

namespace Infrastructure\Http\Response\Responder;

use Infrastructure\Http\Response\Presenter\ResponseHttpHeadersProviderPresenter;
use Infrastructure\Http\Response\Presenter\ResponseHttpStatusCodeProviderPresenter;
use Infrastructure\Http\Response\Presenter\RootDataProviderPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class GenericSerializableResponder
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function __invoke($data, array $serialisationGroups = [], int $httpStatusCode = 0): Response
    {
        //if (!empty($serializationGroups)) {
        //    $serializationContext = new SerializationContext();
        //    $serializationContext->setGroups($serializationGroups);
        //} else {
        //    $serializationContext = null;
        //}

        $exposedData = ($data instanceof RootDataProviderPresenter)
            ? $data->getExposedRootData()
            : $data
        ;

        $jsonData = $this->serializer->serialize($exposedData, 'json', $serialisationGroups);

        $httpStatusCode = (
            $data instanceof ResponseHttpStatusCodeProviderPresenter ? $data->getHttpStatusCode() : $httpStatusCode
        ) ?: Response::HTTP_OK;

        $httpHeaders = ($data instanceof ResponseHttpHeadersProviderPresenter)
            ? $data->getHttpHeaders()
            : []
        ;

        return new JsonResponse($jsonData, $httpStatusCode, $httpHeaders, true);
    }
}
