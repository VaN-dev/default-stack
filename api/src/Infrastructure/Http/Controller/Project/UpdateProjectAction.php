<?php

namespace Infrastructure\Http\Controller\Project;

use Application\Command\Project\UpdateProjectCommand;
use Domain\Model\Repository\Project\ProjectRepository;
use Infrastructure\Http\Request\Input\Put\Project\UpdateProjectRequest;
use Infrastructure\Http\Response\Presenter\Project\ProjectFullPresenter;
use Infrastructure\Http\Response\Responder\GenericSerializableResponder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsController]
readonly class UpdateProjectAction
{
    public function __construct(
        private MessageBusInterface $bus,
        private ProjectRepository $repository,
        private GenericSerializableResponder $responder,
    ) {}

    public function __invoke(UpdateProjectRequest $request, string $uuid): Response
    {
        $command = new UpdateProjectCommand($uuid, $request->title);

        $this->bus->dispatch($command);

        $project = $this->repository->get($uuid);

        return ($this->responder)(new ProjectFullPresenter($project));
    }
}
