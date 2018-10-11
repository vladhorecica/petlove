<?php

namespace Petlove\Domain\Catalog\Category\Command;

use Petlove\Domain\BackendUser\Value\BackendUserId;
use Petlove\Domain\Catalog\Category\Value\CategoryId;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class DeleteCategory
{
    /** @var BackendUserId */
    private $id;

    /**
     * DeleteCategory constructor.
     *
     * @param CategoryId $id
     */
    public function __construct(CategoryId $id)
    {
        $this->id = $id;
    }

    /**
     * @return CategoryId
     */
    public function getId()
    {
        return $this->id;
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
    }
}
