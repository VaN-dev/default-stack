<?php

namespace Domain\Model\Validation\Project;

use Symfony\Component\Validator\Constraint;

class ValidTitle extends Constraint
{
    public string $message = 'validation.project.invalid_title';

    public function getTargets(): string
    {
        return self::PROPERTY_CONSTRAINT;
    }
}
