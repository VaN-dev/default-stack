<?php

namespace Application\EventListener\Kernel;

use Application\Exception\SymfonyValidationErrorsException;
use Infrastructure\Http\Response\Responder\ExceptionResponder;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Throwable;

class ExceptionJsonFormatterListener
{
    private ExceptionResponder $exceptionResponder;
    private ?LoggerInterface $logger;

    public function __construct(ExceptionResponder $exceptionResponder, ?LoggerInterface $logger)
    {
        $this->exceptionResponder = $exceptionResponder;
        $this->logger = $logger ?: new NullLogger();
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $validationErrors = $exception instanceof SymfonyValidationErrorsException ?
            $this->extractErrorCodes($exception) : null;

        $this->logException(
            $exception,
            vsprintf('Uncaught PHP Exception %s: "%s" at %s line %s', [
                get_class($exception),
                $exception->getMessage(),
                $exception->getFile(),
                $exception->getLine(),
            ]), $validationErrors
        );

        $response = ($this->exceptionResponder)($exception);

        $event->setResponse($response);
    }

    /**
     * Logs an exception.
     * (this method is a copy-paste of "\Symfony\Component\HttpKernel\EventListener\ExceptionListener").
     *
     * @param Throwable $exception The \Exception instance
     * @param string $message The error message to log
     */
    protected function logException(Throwable $exception, string $message, ?array $validationErrors): void
    {
        if (null !== $this->logger) {
            $context = [
                'exception' => $exception,
            ];

            if (null !== $validationErrors) {
                $context['validation-errors'] = $validationErrors;
            }

            if (!$exception instanceof HttpExceptionInterface || $exception->getStatusCode() >= 500) {
                $this->logger->critical($message, $context);
            } else {
                $this->logger->error($message, $context);
            }
        }
    }

    private function extractErrorCodes(SymfonyValidationErrorsException $exception): array
    {
        return array_map(static function (ConstraintViolation $error) {
            return $error->getMessage();
        }, iterator_to_array($exception->getErrors()));
    }
}
