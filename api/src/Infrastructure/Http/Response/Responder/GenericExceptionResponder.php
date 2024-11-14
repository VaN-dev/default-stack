<?php

namespace Infrastructure\Http\Response\Responder;

use Application\Exception\SymfonyValidationErrorsException;
use InvalidArgumentException;
use LogicException;
use ReflectionClass;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Throwable;

class GenericExceptionResponder implements ExceptionResponder
{
    private bool $debug;
    private string $env;

    public function __construct(bool $debug, string $env)
    {
        $this->debug = $debug;
        $this->env = $env;
    }

    public function __invoke(Throwable $exception): Response
    {
        ['data' => $errorData, 'httpCode' => $httpErrorCode] = $this->getExceptionData($exception);

        return $this->getResponseFromExceptionData($exception, $errorData, $httpErrorCode);
    }

    public function getResponseFromExceptionData(Throwable $exception, array $errorData, int $httpErrorCode): Response
    {
        if ($this->debug) {
            $errorData['detail'] = [
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'stackTrace' => $exception->getTraceAsString(),
            ];
        }

        return new JsonResponse($errorData, $httpErrorCode);
    }

    private function getSymfonyValidatorErrorsExceptionData(
        SymfonyValidationErrorsException $exception,
        ?string $message = null
    ): array
    {
        $validationErrors = $exception->getErrors();

        $validationErrors = array_map(
            function (ConstraintViolationInterface $violation): array {
                return array_filter([
                    'field' => $violation->getPropertyPath(),
                    'message' => $violation->getMessage(),
                    'parameters' => $this->removeSymfonyValidatorCurlyBraces($violation->getParameters()),
                ]);
            },
            iterator_to_array($validationErrors)
        );

        return [
            'data' => [
                'message' => $message ?: 'Validation Failed',
                'errors' => $validationErrors,
            ],
            'httpCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
        ];
    }

    private function getExceptionData(Throwable $exception): array
    {
        if ($exception instanceof SymfonyValidationErrorsException) {
            return $this->getSymfonyValidatorErrorsExceptionData($exception);
        }

        return $this->getGenericErrorData($exception);
    }

    private function getGenericErrorData(Throwable $exception): array
    {
        /*
         * Don't display any sensitive tech informations in production,
         * like absolute file path, class namespaces, etc ...
         */
        $message = $exception->getMessage();
        if ('prod' === $this->env && false === $this->debug) {
            $errorCodesConsts = (new ReflectionClass(ErrorCodesConsts::class))->getConstants();

            if (false === in_array($message, $errorCodesConsts, true)) {
                $message = 'Generic exception occured!';
            }
        }

        $exceptionData = [
            'message' => $message,
        ];
        $this->addErrorCodeIfAny($exception, $exceptionData);

        $httpCode = $this->getHttpStatusCode($exception);

        return [
            'data' => $exceptionData,
            'httpCode' => $httpCode,
        ];
    }

    private function getHttpStatusCode(Throwable $exception): int
    {
        return match (true) {
            $exception instanceof NotFoundHttpException => Response::HTTP_NOT_FOUND,
            $exception instanceof UnprocessableEntityHttpException,
                $exception instanceof ValidationFailedException => Response::HTTP_UNPROCESSABLE_ENTITY,
            $exception instanceof MethodNotAllowedHttpException => Response::HTTP_METHOD_NOT_ALLOWED,
            $exception instanceof AccessDeniedHttpException => Response::HTTP_FORBIDDEN,
            $exception instanceof InvalidArgumentException,
                $exception instanceof LogicException => Response::HTTP_BAD_REQUEST,
            $exception instanceof HttpException => $exception->getStatusCode(),
            default => Response::HTTP_INTERNAL_SERVER_ERROR,
        };
    }

    private function addErrorCodeIfAny(Throwable $exception, array &$responseData): void
    {
        if (!empty($code = $exception->getCode())) {
            $responseData['code'] = $code;
        }
    }

    private function removeSymfonyValidatorCurlyBraces(array $symfonyViolationParameters): array
    {
        $result = [];
        foreach ($symfonyViolationParameters as $keyWithCurlyBraces => $value) {
            $result[preg_replace('~\{\{\s*(.+)\s* \}\}~', '$1', $keyWithCurlyBraces)] = $value;
        }

        return $result;
    }
}
