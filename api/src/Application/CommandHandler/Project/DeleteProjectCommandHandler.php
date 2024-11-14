<?php

namespace Application\CommandHandler\Project;

use Application\Command\Project\DeleteProjectCommand;
use Doctrine\ORM\EntityManagerInterface;
use Domain\Model\Repository\Project\ProjectRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

final readonly class DeleteProjectCommandHandler
{
    public function __construct(
        private EntityManagerInterface $em,
        private ProjectRepository $repository,
    ) {}

    public function __invoke(DeleteProjectCommand $command): void
    {
        $project = $this->repository->get($command->uuid);

        $this->em->remove($project);
        $this->em->flush();
    }
}
