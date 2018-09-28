<?php

namespace Petlove\Domain\Catalog\Category\Value;

use Petlove\Domain\Catalog\Category\Validation\CategoryExists;
use Util\Value\IntegerValueObject;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class CategoryId extends IntegerValueObject
{
    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addConstraints([
            new CategoryExists()
        ]);
    }
}
