<?php

namespace Petlove\ApiBundle\Controller\Backend;

use Petlove\ApiBundle\Controller\ApiController;
use Petlove\ApiBundle\DataProcessor\Catalog\Category\CreateCategoryProcessor;
use Petlove\ApiBundle\DataProcessor\Catalog\Category\UpdateCategoryProcessor;
use Petlove\ApiBundle\DataProcessor\PageProcessor;
use Petlove\Domain\Catalog\Category\Category;
use Petlove\Domain\Catalog\Category\Command\DeleteCategory;
use Petlove\Domain\Catalog\Category\Value\CategoryId;
use Petlove\Domain\Common\Exception\ValidationError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Util\Value\Page;

/**
 * Class CategoryController
 * @package Petlove\ApiBundle\Controller\Backend
 */
class CategoriesController extends ApiController
{
    public function deleteAction($categoryId): JsonResponse
    {
        $categoryId = new CategoryId((int)$categoryId);

        try {
            $this->get('petlove.catalog_category_service')->delete(
                $this->getAuthorization(),
                new DeleteCategory($categoryId)
            );
        } catch (ValidationError $ex) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    public function findAction($categoryId): JsonResponse
    {
        /** @var Category $category */
        $category = $this->get('petlove.catalog_category_service')->find(
            $this->getAuthorization(),
            new CategoryId((int)$categoryId)
        );

        return new JsonResponse($category->jsonSerialize());
    }

    public function getAllAction(): JsonResponse
    {
        $data = $this->getQueryData();

        /** @var Page $page */
        $page = $data
            ->process(new PageProcessor(self::SEARCH_DEFAULT_OFFSET, null, self::SEARCH_DEFAULT_SIZE, null))
            ->get();

        $collection = $this->get('petlove.catalog_category_service')->query(
            $this->getAuthorization(),
        null,
            $page
        );

        $responseData = [
            'meta' => [
                'total' => $collection->getTotal(),
                'offset' => $collection->getPage()->getOffset(),
                'size' => $collection->getPage()->getSize(),
            ],
            'data' => [],
        ];

        /** @var Category $category */
        foreach ($collection as $category) {
            $responseData['data'][] = $category->jsonSerialize();
        }

        return new JsonResponse($responseData);
    }

    public function postAction(): JsonResponse
    {
        $data = $this->getRequestData();
        $cmd = $data->process(new CreateCategoryProcessor())->get();
        $this->get('petlove.catalog_category_service')->create($this->getAuthorization(), $cmd);

        return new JsonResponse(null, Response::HTTP_CREATED);
    }

    public function putAction($categoryId): JsonResponse
    {
        $data = $this->getRequestData();
        $updateCmd = $data->process(new UpdateCategoryProcessor(new CategoryId((int)$categoryId)))->get();
        $this->get('petlove.catalog_category_service')->update($this->getAuthorization(), $updateCmd);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
