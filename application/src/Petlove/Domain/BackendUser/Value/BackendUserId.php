<?php

namespace Petlove\Domain\BackendUser\Value;

use Petlove\Domain\BackendUser\Validation\BackendUserExists;
use Util\Value\IntegerValueObject;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class BackendUserId extends IntegerValueObject
{
    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addGetterConstraints('value', [
            new BackendUserExists(),
        ]);
    }
}
