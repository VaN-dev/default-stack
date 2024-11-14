<?php

namespace Application\Command\Project;

final readonly class DeleteProjectCommand
{
    public function __construct(
        public string $uuid,
    ) {}
}
