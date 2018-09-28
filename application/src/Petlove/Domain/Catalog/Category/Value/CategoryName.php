<?php

namespace Petlove\Domain\Catalog\Category\Value;

use Util\Value\StringValueObject;
use Petlove\Domain\Catalog\Category\Validation\UniqueCategoryName;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class CategoryName extends StringValueObject
{
    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addGetterConstraints('value', [
            new NotNull(),
            new NotBlank(),
            new UniqueCategoryName(),
        ]);
    }
}
