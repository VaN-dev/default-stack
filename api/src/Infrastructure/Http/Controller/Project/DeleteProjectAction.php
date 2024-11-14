<?php

namespace Infrastructure\Http\Controller\Project;

use Application\Command\Project\DeleteProjectCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsController]
readonly class DeleteProjectAction
{
    public function __construct(private MessageBusInterface $bus)
    {}

    public function __invoke(Request $request): JsonResponse
    {
        // @todo: implements the custom Request layer
        $uuid = $request->get('uuid');

        $command = new DeleteProjectCommand($uuid);

        $this->bus->dispatch($command);

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
