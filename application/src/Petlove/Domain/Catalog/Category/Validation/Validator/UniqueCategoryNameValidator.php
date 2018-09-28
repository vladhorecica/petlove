<?php

namespace Petlove\Domain\Catalog\Category\Validation\Validator;

use Petlove\Domain\Catalog\Category\Command\UpdateCategory;
use Petlove\Domain\Catalog\Category\CategoryLightSpecification;
use Petlove\Domain\Catalog\Category\CategoryRepository;
use Petlove\Domain\Catalog\Category\Validation\UniqueCategoryName;
use Petlove\Domain\Catalog\Category\Value\CategoryName;
use Symfony\Component\Validator\Constraint;

class UniqueCategoryNameValidator extends Constraint
{
    /** @var CategoryLightSpecification */
    private $categorySpec;

    /** @var CategoryRepository */
    private $categoryRepository;

    /**
     * UniqueCategoryNameValidator constructor.
     *
     * @param CategoryLightSpecification $categorySpec
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryLightSpecification $categorySpec, CategoryRepository $categoryRepository)
    {
        $this->categorySpec = $categorySpec;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof UniqueCategoryName) {
            throw new \InvalidArgumentException('Invalid category validation rule provided.');
        }

        $root = $this->context->getRoot();
        if ($root instanceof UpdateCategory) {
            $category = $this->categoryRepository->find($root->getId());
            if ($category->getName()->equals($root->getName())) {
                // prevent triggering uniqueness violation on the same entity
                return;
            }
        }

        if ($this->categorySpec->existsByName(new CategoryName($value))) {
            $this->context->addViolation('category_name_must_be_unique: '.$value);
        }
    }
}
