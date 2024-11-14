<?php

namespace Application\Command\Project;

use Domain\Model\Validation as DomainConstraints;
use Symfony\Component\Validator\Mapping\ClassMetadata;

final readonly class CreateProjectCommand
{
    public function __construct(
        public string $uuid,
        public string $title
    ) {}

    /**
     * This method is automatically called by the Symfony Validator
     * when we ask it to validate an instance of that class.
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraints('title', [
            new DomainConstraints\Project\ValidTitle(),
        ]);
    }
}
