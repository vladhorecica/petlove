<?php

namespace Petlove\Domain\Catalog\Category;

use Petlove\Domain\Catalog\CatalogAuthorization;
use Petlove\Domain\Catalog\Category\Command\CreateCategory;
use Petlove\Domain\Catalog\Category\Command\DeleteCategory;
use Petlove\Domain\Catalog\Category\Command\UpdateCategory;
use Petlove\Domain\Catalog\Category\Value\CategoryId;
use Petlove\Domain\Security\Exception\AuthenticationError;
use Petlove\Domain\Security\Exception\AuthorizationError;
use Util\Value\Page;
use Petlove\Domain\Common\Exception\ValidationError;
use Petlove\Domain\Common\Query\Result;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CategoryService
 * @package Petlove\Domain\Catalog\Category
 */
class CategoryService
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepo;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(
        CategoryRepository $categoryRepo,
        ValidatorInterface $validator
    ) {
        $this->categoryRepo = $categoryRepo;
        $this->validator    = $validator;
    }

    public function create(CatalogAuthorization $authorization, CreateCategory $cmd): CategoryId
    {
        if ($authorization->isAnonymous()) {
            throw new AuthenticationError();
        }
        if (!$authorization->canManageCatalog()) {
            throw new AuthorizationError();
        }
        if (count($violations = $this->validator->validate($cmd)) > 0) {
            throw new ValidationError($violations);
        }

        return $this->categoryRepo->create($cmd);
    }

    public function update(CatalogAuthorization $authorization, UpdateCategory $cmd)
    {
        if ($authorization->isAnonymous()) {
            throw new AuthenticationError();
        }
        if (!$authorization->canManageCatalog()) {
            throw new AuthorizationError();
        }
        if (count($violations = $this->validator->validate($cmd)) > 0) {
            throw new ValidationError($violations);
        }

        $this->categoryRepo->update($cmd);
    }

    public function delete(CatalogAuthorization $authorization, DeleteCategory $cmd)
    {
        if ($authorization->isAnonymous()) {
            throw new AuthenticationError();
        }

        if (!$authorization->canManageCatalog()) {
            throw new AuthorizationError();
        }

        if (count($violations = $this->validator->validate($cmd)) > 0) {
            throw new ValidationError($violations);
        }

        $this->categoryRepo->delete($cmd->getId());
    }

    /**
     * @param CatalogAuthorization $authorization
     * @param mixed $filter
     * @param Page|null $page
     *
     * @return Category[]|Result
     */
    public function query(CatalogAuthorization $authorization, $filter = null, Page $page = null)
    {
        if ($authorization->isAnonymous()) {
            throw new AuthenticationError();
        }
        if (!$authorization->canManageCatalog()) {
            throw new AuthorizationError();
        }

        return $this->categoryRepo->query($filter, $page);
    }

    /**
     * @param CatalogAuthorization $authorization
     * @param CategoryId $userId
     *
     * @return Category
     */
    public function find(CatalogAuthorization $authorization, CategoryId $categoryId)
    {
        if ($authorization->isAnonymous()) {
            throw new AuthenticationError();
        }
        if (!$authorization->canAccessCatalog()) {
            throw new AuthorizationError();
        }

        return $this->categoryRepo->find($categoryId);
    }
}
