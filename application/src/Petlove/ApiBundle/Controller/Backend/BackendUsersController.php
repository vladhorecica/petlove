<?php

namespace Petlove\ApiBundle\Controller\Backend;

use Petlove\ApiBundle\Controller\ApiController;
use Petlove\ApiBundle\DataProcessor\BackendUser\CreateBackendUserProcessor;
use Petlove\ApiBundle\DataProcessor\BackendUser\UpdateBackendUserProcessor;
use Petlove\ApiBundle\DataProcessor\PageProcessor;
use Petlove\Domain\BackendUser\BackendUser;
use Petlove\Domain\BackendUser\Command\DeleteBackendUser;
use Petlove\Domain\BackendUser\Value\BackendUserId;
use Petlove\Domain\Common\Exception\ValidationError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Util\Value\Page;

class BackendUsersController extends ApiController
{
    /**
     * @param mixed $userId
     *
     * @return JsonResponse
     */
    public function deleteAction($userId)
    {
        $userId = new BackendUserId((int)$userId);

        try {
            $this->get('petlove.backend_user_service')->delete(
                $this->getAuthorization(),
                new DeleteBackendUser($userId)
            );
        } catch (ValidationError $ex) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    public function findAction($userId)
    {
        /** @var BackendUser $user */
        $user = $this->get('petlove.backend_user_service')->find(
            $this->getAuthorization(),
            new BackendUserId((int)$userId)
        );

        return new JsonResponse($user->jsonSerialize());
    }

    /**
     * @return JsonResponse
     */
    public function getAllAction()
    {
        $data = $this->getQueryData();

        /** @var Page $page */
        $page = $data
            ->process(new PageProcessor(self::SEARCH_DEFAULT_OFFSET, null, self::SEARCH_DEFAULT_SIZE, null))
            ->get();

        $collection = $this->get('petlove.backend_user_service')->query(
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

        /** @var BackendUser $user */
        foreach ($collection as $user) {
            $responseData['data'][] = $user->jsonSerialize();
        }

        return new JsonResponse($responseData);
    }

    /**
     * @return JsonResponse
     */
    public function postAction()
    {
        $data = $this->getRequestData();
        $cmd = $data->process(new CreateBackendUserProcessor())->get();
        $this->get('petlove.backend_user_service')->create($this->getAuthorization(), $cmd);

        return new JsonResponse(null, Response::HTTP_CREATED);
    }

    /**
     * @param $userId
     *
     * @return JsonResponse
     */
    public function putAction($userId)
    {
        $data = $this->getRequestData();
        $updateCmd = $data->process(new UpdateBackendUserProcessor(new BackendUserId((int) $userId)))->get();
        $this->get('petlove.backend_user_service')->update($this->getAuthorization(), $updateCmd);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);    }
}
