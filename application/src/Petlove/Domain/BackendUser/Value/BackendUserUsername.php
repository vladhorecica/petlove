<?php

namespace Petlove\Domain\BackendUser\Value;

use Util\Value\StringValueObject;
use Petlove\Domain\BackendUser\Validation\UniqueBackendUserUsername;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class BackendUserUsername extends StringValueObject
{
    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addGetterConstraints('value', [
            new NotNull(),
            new NotBlank(),
            new UniqueBackendUserUsername(),
        ]);
    }
}
