<?php

namespace Petlove\Domain\BackendUser\Value;

use Petlove\Domain\BackendUser\Validation\UniqueBackendUserEmail;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Util\Value\StringValueObject;

class BackendUserEmail extends StringValueObject
{
    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addGetterConstraints('value', [
            new UniqueBackendUserEmail(),
            new Email(),
        ]);
    }
}
