<?php

namespace Infrastructure\Http\Controller\Project;

use Domain\Model\Repository\Project\ProjectRepository;
use Infrastructure\Http\Response\Presenter\Project\ProjectFullPresenter;
use Infrastructure\Http\Response\Responder\GenericSerializableResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
readonly class GetProjectAction
{
    public function __construct(
        private ProjectRepository $repository,
        private GenericSerializableResponder $responder,
    )
    {}

    public function __invoke(Request $request): Response
    {
        $uuid = $request->get('uuid');

        $project = $this->repository->get($uuid);

        return ($this->responder)(new ProjectFullPresenter($project));
    }
}
