<?php

namespace Petlove\Domain\Security;

use Petlove\Domain\BackendUser\BackendUser;
use Petlove\Domain\Security\Authorization\BackendAuthorization;

class BackendAuthentication
{
    /** @var BackendSession */
    private $session;
    /** @var BackendAuthorization */
    private $authorization;

    /**
     * @param BackendSession       $session
     * @param BackendAuthorization $authorization
     */
    public function __construct(BackendSession $session, BackendAuthorization $authorization)
    {
        $this->session = $session;
        $this->authorization = $authorization;
    }

    /**
     * @return BackendSession
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @return BackendAuthorization
     */
    public function getAuthorization()
    {
        return $this->authorization;
    }

    /**
     * @return BackendUser
     */
    public function getBackendUser()
    {
        return $this->authorization->getUser();
    }
}
