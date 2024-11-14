<?php

namespace Application\Exception;

use InvalidArgumentException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class SymfonyValidationErrorsException extends InvalidArgumentException
{
    private ConstraintViolationListInterface $validatorErrors;

    public function __construct(ConstraintViolationListInterface $validatorErrors)
    {
        $this->validatorErrors = $validatorErrors;

        parent::__construct();
    }

    public function getErrors(): ConstraintViolationListInterface
    {
        return $this->validatorErrors;
    }
}
