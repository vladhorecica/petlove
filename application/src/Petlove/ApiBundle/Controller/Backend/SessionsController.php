<?php

namespace Petlove\ApiBundle\Controller\Backend;

use Util\Data\Processor\ScalarVoProcessor;
use Petlove\ApiBundle\Controller\ApiController;
use Petlove\Domain\BackendUser\Query\BackendUserEmailFilter;
use Petlove\Domain\BackendUser\Value\BackendUserEmail;
use Petlove\Domain\Security\Command\BackendLogin;
use Petlove\Domain\Security\Command\DeleteSession;
use Petlove\Domain\Security\Value\SessionId;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SessionsController extends ApiController
{
    /**
     * @return JsonResponse
     */
    public function postAction()
    {
        $data = $this->getRequestData();
        $password = $data->access('password')->getString();
        $email = $data->access('email')->process(new ScalarVoProcessor(BackendUserEmail::class))->get();

        $cmd = new BackendLogin($email, $password);

        $sessionId = $this->container->get('kadanza.security_service')->login($this->getAuthorization(), $cmd);

        $user = $this->container->get('kadanza.backend_user_repository')
            ->query(new BackendUserEmailFilter($cmd->getEmail()))->getIterator()->current();

        return new JsonResponse([
            'token' => $sessionId,
            'type'  => $user->getType()
        ], Response::HTTP_CREATED);
    }

    /**
     * @param string $sessionId
     *
     * @return JsonResponse
     */
    public function deleteAction($sessionId)
    {
        $cmd = new DeleteSession(new SessionId($sessionId));
        $this->container->get('kadanza.security_service')->logout($this->getAuthorization(), $cmd);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @return JsonResponse
     */
    public function patchAction()
    {
        // keep alive

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
