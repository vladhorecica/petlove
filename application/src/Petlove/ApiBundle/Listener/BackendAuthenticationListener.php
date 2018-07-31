<?php

namespace Petlove\ApiBundle\Listener;

//use Petlove\Domain\Security\Authorization\AnonymousAuthorization;
//use Petlove\Domain\Security\Service\SecurityService;
//use Petlove\Domain\Security\Value\SessionId;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class BackendAuthenticationListener
{
//    /** @var SecurityService */
//    private $securityService;
//
//    /**
//     * @param SecurityService $securityService
//     */
//    public function __construct(SecurityService $securityService)
//    {
//        $this->securityService = $securityService;
//    }

    public function __construct()
    {

    }

    /**
     * @param GetResponseEvent $event
     */
    public function onRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

//        if (!$request->headers->has('Authorization')) {
//            $request->attributes->set('petlove.authorization', new AnonymousAuthorization());
//
//            return;
//        }
//
//        $sessionId = new SessionId($request->headers->get('Authorization'));
//        $result = $this->securityService->resumeBackendSession($sessionId);
//        $request->attributes->set('petlove.session', $result->getSession());
//        $request->attributes->set('petlove.authorization', $result->getAuthorization());
    }
}
