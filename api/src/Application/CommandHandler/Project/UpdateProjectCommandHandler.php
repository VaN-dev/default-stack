<?php

namespace Application\CommandHandler\Project;

use Application\Command\Project\UpdateProjectCommand;
use Doctrine\ORM\EntityManagerInterface;
use Domain\Model\Repository\Project\ProjectRepository;

final readonly class UpdateProjectCommandHandler
{
    public function __construct(
        private EntityManagerInterface $em,
        private ProjectRepository $repository,
    ) {}

    public function __invoke(UpdateProjectCommand $command): void
    {
        $project = $this->repository->get($command->uuid);

        $project->update($command->title);

        $this->em->flush();
    }
}
