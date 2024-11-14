<?php

namespace Domain\Model\Validation\Project;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class ValidTitleValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof ValidTitle) {
            throw new UnexpectedTypeException($constraint, ValidTitle::class);
        }

        $isValid = !str_contains($value, 'playplay');

        if ($isValid === false) {
            $this->context->buildViolation($constraint->message)
                ->atPath('parent')
                ->addViolation()
            ;
        }
    }
}
