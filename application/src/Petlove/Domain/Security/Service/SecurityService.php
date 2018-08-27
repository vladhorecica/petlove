<?php

namespace Petlove\Domain\Security\Service;

use Petlove\Domain\BackendUser\BackendUserRepository;
use Petlove\Domain\Common\Exception\NotFoundError;
use Petlove\Domain\Common\Exception\NotImplementedError;
use Petlove\Domain\Security\Authorization\Authorization;
use Petlove\Domain\Security\Authorization\BackendAuthorization;
use Petlove\Domain\Security\BackendAuthentication;
use Petlove\Domain\Security\BackendSessionRepository;
use Petlove\Domain\Security\Command\BackendLogin;
use Petlove\Domain\Security\Command\DeleteSession;
use Petlove\Domain\Security\Exception\AuthenticationError;
use Petlove\Domain\Security\Exception\AuthorizationError;
use Petlove\Domain\Security\Value\SessionId;

class SecurityService
{
    /**
     * @var BackendSessionRepository
     */
    private $backendSessionRepo;

    /**
     * @var BackendUserRepository
     */
    private $backendUserRepo;

    /**
     * @var AuthorizationService
     */
    private $authorizationService;
    /**
     * @var LoginLogoutService
     */
    private $loginLogoutService;

    /**
     * SecurityService constructor.
     *
     **@param AuthorizationService     $authorizationService
     * @param LoginLogoutService        $loginLogoutService
     * @param BackendSessionRepository  $backendSessionRepo
     * @param BackendUserRepository     $backendUserRepo
     */
    public function __construct(
        AuthorizationService $authorizationService,
        LoginLogoutService $loginLogoutService,
        BackendSessionRepository $backendSessionRepo,
        BackendUserRepository $backendUserRepo
    ) {
        $this->loginLogoutService = $loginLogoutService;
        $this->authorizationService = $authorizationService;
        $this->backendSessionRepo = $backendSessionRepo;
        $this->backendUserRepo = $backendUserRepo;
    }

    /**
     * @param Authorization                                                    $authorization
     * @param BackendLogin $cmd
     *
     * @return SessionId
     */
    public function login(Authorization $authorization, $cmd)
    {
        if (!$authorization->canLogin()) {
            throw new AuthorizationError("Not allowed to login.");
        }

        if ($cmd instanceof BackendLogin) {
            return $this->loginLogoutService->backendLogin($cmd);
        }

        throw new NotImplementedError();
    }

    /**
     * @param Authorization $authorization
     * @param DeleteSession $cmd
     *
     * @return $this
     */
    public function logout(Authorization $authorization, DeleteSession $cmd)
    {
        if ($authorization->isAnonymous()) {
            throw new AuthenticationError();
        }

        if ($authorization instanceof BackendAuthorization) {
            $this->loginLogoutService->backendLogout($authorization, $cmd);

            return $this;
        }

        throw new AuthenticationError();
    }

    /**
     * @param SessionId $sessionId
     *
     * @return BackendAuthentication
     */
    public function resumeBackendSession(SessionId $sessionId)
    {
        try {
            $session = $this->backendSessionRepo->find($sessionId);
        } catch (NotFoundError $e) {
            throw new AuthenticationError();
        }

        $user = $this->backendUserRepo->get($session->getBackendUser());
        $authorization = $this->authorizationService->createBackendUserAuthorization($user);

        if (!$authorization->canResumeSession()) {
            throw new AuthorizationError('User not active');
        }

        $this->backendSessionRepo->touch($sessionId);

        return new BackendAuthentication($session, $authorization);
    }
}
