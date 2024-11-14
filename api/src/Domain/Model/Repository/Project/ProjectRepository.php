<?php

namespace Domain\Model\Repository\Project;

use Domain\Model\Entity\Project\Project;

interface ProjectRepository
{
    public function list(): array;

    public function get(string $uuid): Project;
}
