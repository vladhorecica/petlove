<?php

namespace Petlove\Domain\Catalog\Category\Command;

use Petlove\Domain\Catalog\Category\Value\CategoryId;
use Petlove\Domain\Catalog\Category\Value\CategoryName;
use Petlove\Domain\Catalog\Category\Value\CategoryType;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Valid;

/**
 * Class UpdateCategory
 * @package Petlove\Domain\Catalog\Category\Command
 */
class UpdateCategory
{
    /** @var CategoryId */
    private $id;

    /** @var CategoryType */
    private $type;

    /** @var CategoryName */
    private $name;

    /** @var CategoryId|null */
    private $parent;

    /**
     * UpdateCategory constructor.
     *
     * @param CategoryId $id
     * @param CategoryName $name
     * @param CategoryType $type
     * @param CategoryId|null $parent
     */
    public function __construct(
        CategoryId $id,
        CategoryName $name,
        CategoryType $type,
        CategoryId $parent = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->parent = $parent;
    }

    public function getId(): CategoryId
    {
        return $this->id;
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
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('id', [
            new NotNull(),
            new Type(CategoryId::class),
            new Valid(),
        ]);

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
