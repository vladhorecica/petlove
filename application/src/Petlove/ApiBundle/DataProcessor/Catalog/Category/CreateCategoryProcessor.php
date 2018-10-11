<?php

namespace Petlove\ApiBundle\DataProcessor\Catalog\Category;

use Petlove\ApiBundle\DataProcessor\DataValidator;
use Petlove\Domain\Catalog\Category\Command\CreateCategory;
use Petlove\Domain\Catalog\Category\Value\CategoryId;
use Petlove\Domain\Catalog\Category\Value\CategoryName;
use Petlove\Domain\Catalog\Category\Value\CategoryType;
use Respect\Validation\Validator;
use Util\Data\DataHelper;
use Util\Data\DataProcessor;
use Util\Data\Processor\ScalarVoProcessor;

/**
 * Class CreateCategoryProcessor
 * @package Petlove\ApiBundle\DataProcessor\Catalog\Category
 */
class CreateCategoryProcessor implements DataProcessor
{
    /**
     * @param mixed $in
     *
     * @return CreateCategory
     */
    public function __invoke($in)
    {
        $validator = new DataValidator(
            Validator::key('type'),
            Validator::key('name'),
            Validator::key('parent_id')
        );

        $validator->assert($in);
        $data = new DataHelper($in);

        return new CreateCategory(
            $data->access('name')->process(new ScalarVoProcessor(CategoryName::class))->get(),
            $data->access('type')->process(new ScalarVoProcessor(CategoryType::class))->get(),
            $data->access('parent_id')->maybe()->process(new ScalarVoProcessor(CategoryId::class))->defaultTo(null)->get()
        );
    }
}
