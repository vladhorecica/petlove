<?php

namespace Petlove\Domain\Security\Service;

use Petlove\Domain\BackendUser\BackendUserRepository;
use Petlove\Domain\BackendUser\Query\BackendUserEmailFilter;
use Petlove\Domain\Common\Exception\ValidationError;
use Petlove\Domain\Security\Authorization\BackendAuthorization;
use Petlove\Domain\Security\BackendSessionRepository;
use Petlove\Domain\Security\Command\BackendLogin;
use Petlove\Domain\Security\Command\DeleteSession;
use Petlove\Domain\Security\Exception\AuthenticationError;
use Petlove\Domain\Security\Exception\AuthorizationError;
use Petlove\Domain\Security\Value\SessionId;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class LoginLogoutService
{
    /**
     * @var BackendSessionRepository
     */
    private $backendSessionRepository;

    /**
     * @var PasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var BackendUserRepository
     */
    private $backendUserRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * SecurityService constructor.
     *
     * @param BackendSessionRepository  $bsRepo
     * @param PasswordEncoderInterface  $passwordEncoder
     * @param BackendUserRepository     $buRepo
     * @param LoggerInterface           $logger
     * @param ValidatorInterface        $validator
     */
    public function __construct(
        BackendSessionRepository $bsRepo,
        PasswordEncoderInterface $passwordEncoder,
        BackendUserRepository $buRepo,
        LoggerInterface $logger,
        ValidatorInterface $validator
    ) {
        $this->backendSessionRepository = $bsRepo;
        $this->passwordEncoder = $passwordEncoder;
        $this->backendUserRepository = $buRepo;
        $this->logger = $logger;
        $this->validator = $validator;
    }

    /**
     * @param BackendLogin $cmd
     *
     * @return SessionId
     */
    public function backendLogin(BackendLogin $cmd)
    {
        if (count($violations = $this->validator->validate($cmd)) > 0) {
            throw new ValidationError($violations);
        }

        $user = $this->backendUserRepository
            ->query(new BackendUserEmailFilter($cmd->getEmail()))->getIterator()->current();

        if (!$user) {
            $this->logger->error("email: {$cmd->getEmail()}", ['security.backend_login.email_invalid']);
            throw new AuthenticationError();
        }

        if (!$this->checkPassword($user->getPassword(), $cmd->getPassword())) {
            throw new AuthenticationError();
        }

        return $this->backendSessionRepository->create($user->getId());
    }

    /**
     * @param BackendAuthorization $authorization
     * @param DeleteSession        $cmd
     */
    public function backendLogout(BackendAuthorization $authorization, DeleteSession $cmd)
    {
        if (count($violations = $this->validator->validate($cmd)) > 0) {
            throw new ValidationError($violations);
        }

        $session = $this->backendSessionRepository->find($cmd->getSession());

        if (!$authorization->canLogout($session->getBackendUser())) {
            $this->logger->info('security.backend_logout.not_allowed', ['session' => $cmd->getSession()]);
            throw new AuthorizationError();
        }

        $this->backendSessionRepository->delete($cmd->getSession());
    }

    /**
     * @param string $encodedPassword
     * @param string $rawPassword
     *
     * @return bool
     */
    private function checkPassword($encodedPassword, $rawPassword)
    {
        return $this->passwordEncoder->isPasswordValid($encodedPassword, $rawPassword, null);
    }
}
