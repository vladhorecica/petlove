<?php

namespace Petlove\Domain\Catalog\Category;

use Petlove\Domain\Catalog\Category\Command\CreateCategory;
use Petlove\Domain\Catalog\Category\Command\UpdateCategory;
use Petlove\Domain\Catalog\Category\Value\CategoryId;
use Petlove\Domain\Common\Query\Result;
use Util\Value\Page;

interface CategoryRepository
{
    public function create(CreateCategory $cmd): CategoryId;

    public function update(UpdateCategory $cmd);

    public function delete(CategoryId $id);

    public function get(CategoryId $id): Category;

    /**
     * @param mixed     $filter
     * @param Page|null $page
     *
     * @return Category[]|Result
     */
    public function query($filter = null, Page $page = null);
}
