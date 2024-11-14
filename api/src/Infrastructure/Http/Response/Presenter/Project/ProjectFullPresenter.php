<?php

namespace Infrastructure\Http\Response\Presenter\Project;

use Domain\Model\Entity\Project\Project;
use Domain\Model\Entity\User\User;
use Infrastructure\Http\Response\Presenter\User\UserLightPresenter;

readonly class ProjectFullPresenter
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

    public function getOwner(): UserLightPresenter
    {
        $user = new User(
            'dummy-uuid',
            'dummy-email',
            'dummy-password',
            'dummy-first-name',
            'dummy-lastname',
        );

        return new UserLightPresenter($user);
    }
}
