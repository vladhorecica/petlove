<?php

namespace Petlove\Domain\BackendUser\Command;

use Petlove\Domain\BackendUser\Value\BackendUserId;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class DeleteBackendUser
{
    /**
     * @var BackendUserId
     */
    private $id;

    /**
     * DeleteBackendUser constructor.
     *
     * @param BackendUserId $id
     */
    public function __construct(BackendUserId $id)
    {
        $this->id = $id;
    }

    /**
     * @return BackendUserId
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
            new Type(BackendUserId::class),
            new Valid(),
        ]);
    }
}
