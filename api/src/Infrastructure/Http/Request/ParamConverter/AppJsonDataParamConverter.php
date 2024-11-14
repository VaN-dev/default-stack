<?php

namespace Infrastructure\Http\Request\ParamConverter;

//use App\Http\CustomHeaderConsts;
use Application\Exception\SymfonyValidationErrorsException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * If a HTTP Action requires a ValueObject from some predetermined domain PHP namespaces, this ParamConverter
 * will create it from JSON raw POST content.
 *
 * If the target class has a 'createFromScalarsArray' static method, this one will be used instead of the class constructor.
 *
 * @codeCoverageIgnore
 * (it this doesn't work we will know it quickly anyway, as our functional tests will break immediately :-)
 */
class AppJsonDataParamConverter implements ParamConverterInterface
{
    private array $appRequestDtoNamespacesPrefixes;
    private ValidatorInterface $validator;

    public function __construct(
        array $appRequestDtoNamespaces,
        ValidatorInterface $validator
    ) {
        $this->appRequestDtoNamespacesPrefixes = $appRequestDtoNamespaces;
        $this->validator = $validator;
    }

    /**
     * {@inheritdoc}
     *
     * @throws NotFoundHttpException
     * @throws SymfonyValidationErrorsException
     */
    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $param = $configuration->getName();
        $requestDataClass = $configuration->getClass();
        /** @var array|null $jsonData */
        $requestJsonData = $request->attributes->get('_json_content');
        $requestAttributesData = $request->attributes->all();
        //$requestHeadersKeys = $request->headers->keys();
        $appHeaders = [];

        //foreach ($requestHeadersKeys as $key) {
        //    if (CustomHeaderConsts::CUSTOM_HEADER_BASE === substr($key, 0, strlen(CustomHeaderConsts::CUSTOM_HEADER_BASE))) {
        //        $appHeaders[$key] = $request->headers->get($key);
        //    }
        //}

        if (null === $requestJsonData) {
            throw new UnprocessableEntityHttpException(sprintf(
                'No JSON request data found to populate parameter "%s" (class "%s").',
                $param,
                $requestDataClass
            ));
        }

        unset($requestJsonData['_format']);

        // Ok, now we can create the ValueObject, and prepare its injection into the Controller
        $requestData = $this->getInputDto($requestDataClass, $requestJsonData, $appHeaders, $requestAttributesData);
        $errors = $this->validator->validate($requestData);
        if (count($errors) > 0) {
            throw new SymfonyValidationErrorsException($errors);
        }

        $request->attributes->set($param, $requestData);

        return true;
    }

    public function supports(ParamConverter $configuration): bool
    {
        if (null === $configuration->getClass()) {
            return false;
        }

        $paramClass = $configuration->getClass();

        foreach ($this->appRequestDtoNamespacesPrefixes as $namespacePrefix) {
            if (str_starts_with($paramClass, (string) $namespacePrefix)) {
                return true;
            }
        }

        return false;
    }

    private function getInputDto(
        string $requestDataClass,
        array $requestJsonData,
        array $appHeaders,
        array $requestAttributesData
    )
    {
        if (method_exists($requestDataClass, 'createFromScalarsArray')) {
            return call_user_func([$requestDataClass, 'createFromScalarsArray'], $requestJsonData);
        }

        return new $requestDataClass($requestJsonData, $appHeaders, $requestAttributesData);
    }
}
