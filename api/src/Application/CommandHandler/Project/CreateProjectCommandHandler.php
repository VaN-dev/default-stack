<?php

namespace Application\CommandHandler\Project;

use Application\Command\Project\CreateProjectCommand;
use Domain\Model\Entity\Project\Project;
use Doctrine\ORM\EntityManagerInterface;

final readonly class CreateProjectCommandHandler
{
    public function __construct(private EntityManagerInterface $em)
    {}

    public function __invoke(CreateProjectCommand $command): void
    {
        $project = new Project(
            $command->uuid,
            $command->title,
        );

        $this->em->persist($project);
        $this->em->flush();
    }
}
