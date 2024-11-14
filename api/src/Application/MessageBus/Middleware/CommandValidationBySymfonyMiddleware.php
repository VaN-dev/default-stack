<?php

namespace Application\MessageBus\Middleware;

use Application\Exception\SymfonyValidationErrorsException;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CommandValidationBySymfonyMiddleware implements MiddlewareInterface
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $message = $envelope->getMessage();

        $violations = $this->validator->validate($message);
        if (\count($violations)) {
            throw new SymfonyValidationErrorsException($violations);
        }

        return $stack->next()->handle($envelope, $stack);
    }
}
