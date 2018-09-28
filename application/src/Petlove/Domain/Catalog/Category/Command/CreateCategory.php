<?php

namespace Petlove\Domain\Catalog\Category\Command;

use Petlove\Domain\Catalog\Category\Value\CategoryId;
use Petlove\Domain\Catalog\Category\Value\CategoryName;
use Petlove\Domain\Catalog\Category\Value\CategoryType;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Valid;

class CreateCategory
{
    /** @var CategoryType */
    private $type;

    /** @var CategoryName */
    private $name;

    /** @var CategoryId|null */
    private $parent;

    /**
     * CreateCategory constructor.
     *
     * @param CategoryName $name
     * @param CategoryType $type
     * @param CategoryId|null $parent
     */
    public function __construct(
        CategoryName $name,
        CategoryType $type,
        CategoryId $parent = null
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->parent = $parent;
    }

    public function getType(): CategoryType
    {
        return $this->type;
    }

    public function getName(): CategoryName
    {
        return $this->name;
    }

    /**
     * @return null|CategoryId
     */
    public function getParent(): CategoryId
    {
        return $this->parent;
    }

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('type', [
            new NotNull(),
            new Type(CategoryType::class),
        ]);

        $metadata->addPropertyConstraints('name', [
            new NotNull(),
            new Type(CategoryName::class),
            new Valid(),
        ]);

        $metadata->addPropertyConstraints('parent', [
            new Type(CategoryId::class),
            new Valid()
        ]);
    }
}
