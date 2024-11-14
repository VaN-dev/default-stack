<?php

namespace Infrastructure\Http\Response\Presenter\Project;

use Domain\Model\Entity\Project\Project;

readonly class ProjectLightPresenter
{
    public function __construct(private Project $project)
    {}

    public function getId(): string
    {
        return $this->project->getUuid();
    }

    public function getTitle(): string
    {
        return $this->project->getTitle();
    }
}
