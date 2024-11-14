<?php

namespace Infrastructure\Http\Controller\Project;

use Application\Command\Project\CreateProjectCommand;
use Domain\Model\Repository\Project\ProjectRepository;
use Infrastructure\Http\Request\Input\Post\Project\CreateProjectRequest;
use Infrastructure\Http\Response\Presenter\Project\ProjectFullPresenter;
use Infrastructure\Http\Response\Responder\GenericSerializableResponder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Uid\Uuid;

#[AsController]
readonly class CreateProjectAction
{
    public function __construct(
        private MessageBusInterface $bus,
        private ProjectRepository $repository,
        private GenericSerializableResponder $responder,
    ) {}

    public function __invoke(CreateProjectRequest $request): Response
    {
        $uuid = Uuid::v4();

        $command = new CreateProjectCommand($uuid, $request->title);

        $this->bus->dispatch($command);

        $project = $this->repository->get($uuid);

        return ($this->responder)(new ProjectFullPresenter($project));
    }
}
