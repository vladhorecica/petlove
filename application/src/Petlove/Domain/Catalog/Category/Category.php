<?php

namespace Petlove\Domain\Catalog\Category;

use Petlove\Domain\Catalog\Category\Value\CategoryId;
use Petlove\Domain\Catalog\Category\Value\CategoryName;
use Petlove\Domain\Catalog\Category\Value\CategoryType;

class Category
{
    /** @var CategoryId */
    private $id;

    /** @var CategoryName */
    private $name;

    /** @var CategoryType */
    private $type;

    /** @var CategoryId|null */
    private $parent;

    /**
     * Category constructor.
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

    public function getName(): CategoryName
    {
        return $this->name;
    }

    public function getType(): CategoryType
    {
        return $this->type;
    }

    /** @return null|CategoryId */
    public function getParent()
    {
        return $this->parent;
    }
}
