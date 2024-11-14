<?php

namespace Infrastructure\Repository\Project;

use Domain\Model\Entity\Project\Project;
use Domain\Model\Repository\Project\ProjectRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * @extends ServiceEntityRepository<Project>
 *
 * @method Project[]    findAll()
 */
class DoctrineProjectRepository implements ProjectRepository
{
    private EntityRepository $baseDoctrineRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->baseDoctrineRepository = $em->getRepository(Project::class);
    }

    /**
     * @return Project[]
     */
    public function list(): array
    {
        return $this->baseDoctrineRepository->findAll();
    }

    public function get(string $uuid): Project
    {
        return $this->baseDoctrineRepository->findOneBy(['uuid' => $uuid]);
    }
}
