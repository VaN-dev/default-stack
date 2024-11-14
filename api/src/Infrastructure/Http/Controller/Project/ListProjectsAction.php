<?php

namespace Infrastructure\Http\Controller\Project;

use Domain\Model\Entity\Project\Project;
use Domain\Model\Repository\Project\ProjectRepository;
use Infrastructure\Http\Response\Presenter\Project\ProjectLightPresenter;
use Infrastructure\Http\Response\Responder\GenericSerializableResponder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
readonly class ListProjectsAction
{
    public function __construct(
        private ProjectRepository $repository,
        private GenericSerializableResponder $responder,
    ) {}

    public function __invoke(): Response
    {
        $projects = $this->repository->list();

        $presenters = array_map(
            static function (Project $project): ProjectLightPresenter {
                return new ProjectLightPresenter($project);
            },
            $projects
        );

        return ($this->responder)($presenters);
    }
}
