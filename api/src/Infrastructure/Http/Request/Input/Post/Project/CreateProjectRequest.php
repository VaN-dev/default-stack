<?php

namespace Infrastructure\Http\Request\Input\Post\Project;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints;

readonly class CreateProjectRequest
{
    public string $title;
    public function __construct(array $inputData)
    {
        $this->title = $inputData['title'];
    }

    /**
     * This method is automatically called by the Symfony Validator
     * when we ask it to validate an instance of that class.
     * (done by the AppJsonDataParamConverter).
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraints('title', [
            new Constraints\Length(['max' => 10]),
        ]);
    }
}
