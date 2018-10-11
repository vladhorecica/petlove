<?php

namespace Petlove\Infrastructure\Catalog\Category;

use Petlove\Domain\Catalog\Category\Category;
use Petlove\Domain\Catalog\Category\CategoryRepository;
use Petlove\Domain\Catalog\Category\Command\CreateCategory;
use Petlove\Domain\Catalog\Category\Command\UpdateCategory;
use Petlove\Domain\Catalog\Category\Value\CategoryId;
use Util\MySql\Connection;
use Util\MySql\Util\SelectQueryBuilder;
use Util\Value\Page;
use Petlove\Domain\Common\Exception\NotFoundError;
use Petlove\Domain\Common\Query\Result;
use Petlove\Infrastructure\Common\Cache;
use Petlove\Infrastructure\Common\MysqlResultBuilder;

/**
 * Class MysqlCategoryRepository
 * @package Petlove\Infrastructure\Catalog\Category
 */
class MysqlCategoryRepository implements CategoryRepository
{
    use MysqlResultBuilder;

    /**
     * @var Connection
     */
    private $mysql;

    /**
     * @var Cache
     */
    private $categoryCache;

    /**
     * MysqlCategoryRepository constructor.
     *
     * @param Connection               $db
     * @param Cache                    $cache
     */
    public function __construct(Connection $db, Cache $cache)
    {
        $this->mysql = $db;
        $this->categoryCache = $cache;
    }

    public function create(CreateCategory $cmd): CategoryId
    {
        $id = $this->mysql->insert(
            'catalog_categories',
            [
                'name'       => $cmd->getName(),
                'type'       => $cmd->getType(),
                'parent_id'  => $cmd->getParent(),
                'created_at' => time(),
            ]
        );

        return new CategoryId($id);
    }

    public function update(UpdateCategory $cmd)
    {
        $data = [
            'name'      => $cmd->getName(),
            'type'      => $cmd->getType(),
            'parent_id' => $cmd->getParent()
        ];


        $this->mysql->update('catalog_categories', $data, ['id' => $cmd->getId()]);

        $this->categoryCache->remove($cmd->getId());
    }

    public function find(CategoryId $id): Category
    {
        return $this->categoryCache->get($id, function () use ($id) {
            $category = $this->mysql->bufferedQuery('
              SELECT * FROM catalog_categories c WHERE c.id = ?
            ', $id)->fetchRow();

            if (!$category) {
                throw new NotFoundError('No category found!');
            }

            $category = (new CategoryMysqlToDomainMapper())->map($category);

            $this->categoryCache->set($id, $category);

            return $category;
        });
    }

    public function delete(CategoryId $id)
    {
        $this->mysql->delete('catalog_categories', ['id' => $id]);

        $this->categoryCache->remove($id);
    }

    /**
     * @param mixed     $filter
     * @param Page|null $page
     *
     * @return Result|Category[]
     */
    public function query($filter = null, Page $page = null)
    {
        $query = new SelectQueryBuilder('catalog_categories c');
        $queryTranslator = new MysqlCategoryQueryTranslator();
        $query->andWhere($queryTranslator->translateFilter($filter));
        $query->limit($page);

        $mapper = new CategoryMysqlToDomainMapper();

        return $this->createResult(
            $this->mysql,
            $query,
            function (array $data) use ($mapper) {
                $category = $mapper->map(
                    $data
                );
                $this->categoryCache->set($category->getId(), $category);
                return $category;
            }
        );
    }
}
