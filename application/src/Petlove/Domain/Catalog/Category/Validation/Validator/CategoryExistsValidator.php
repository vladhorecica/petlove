<?php

namespace Petlove\Domain\Catalog\Category\Validation\Validator;

use Petlove\Domain\Catalog\Category\CategoryLightSpecification;
use Petlove\Domain\Catalog\Category\Validation\CategoryExists;
use Petlove\Domain\Catalog\Category\Value\CategoryId;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CategoryExistsValidator extends ConstraintValidator
{
    /**
     * @var CategoryLightSpecification
     */
    private $categorySpec;

    /**
     * CategoryExistsValidator constructor.
     *
     * @param CategoryLightSpecification $categorySpec
     */
    public function __construct(CategoryLightSpecification $categorySpec)
    {
        $this->categorySpec = $categorySpec;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof CategoryExists) {
            throw new \InvalidArgumentException('Invalid validation rule specified for category.');
        }

        if (!($value instanceof CategoryId)) {
            return;
        }

        if (!$this->categorySpec->exists($value)) {
            $this->context->addViolation('category_does_not_exist : '.$value);
        }
    }
}
