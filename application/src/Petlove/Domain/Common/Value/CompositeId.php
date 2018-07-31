<?php

namespace Petlove\Domain\Common\Value;

use Util\Value\IntegerValueObject;
use Util\Value\ValueObject;
use Petlove\Domain\Tenant\Value\TenantId;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\Validator\Mapping\ClassMetadata;

abstract class CompositeId implements ValueObject, \JsonSerializable
{
    /**
     * @var TenantId
     */
    private $tenant;

    /**
     * @var IntegerValueObject
     */
    private $id;

    /**
     * @param TenantId           $tenant
     * @param IntegerValueObject $id
     */
    public function __construct(TenantId $tenant, IntegerValueObject $id)
    {
        $this->tenant = $tenant;
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return sprintf('%s-%s', $this->tenant, $this->id);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getValue();
    }

    /**
     * @param ValueObject|null $other
     *
     * @return bool
     */
    public function equals(ValueObject $other = null)
    {
        return $other instanceof self
            && $this->tenant->equals($other->getTenant())
            && $this->id->equals($other->getInternalId())
        ;
    }

    /**
     * @return IntegerValueObject
     */
    public function getInternalId()
    {
        return $this->id;
    }

    /**
     * @return TenantId
     */
    public function getTenant()
    {
        return $this->tenant;
    }

    /**
     * @return IntegerValueObject
     */
    public function jsonSerialize()
    {
        return $this->id;
    }

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('tenant', [
            new NotNull(),
            new Type(TenantId::class),
            new Valid(),
        ]);

        $metadata->addPropertyConstraints('id', [
            new NotNull(),
            new Type(IntegerValueObject::class),
        ]);
    }
}
