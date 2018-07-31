<?php

namespace Petlove\Domain\BackendUser;

use Util\Value\Page;
use Petlove\Domain\BackendUser\Command\CreateBackendUser;
use Petlove\Domain\BackendUser\Command\DeleteBackendUser;
use Petlove\Domain\BackendUser\Command\UpdateBackendUser;
use Petlove\Domain\BackendUser\Value\BackendUserId;
use Petlove\Domain\Common\Exception\ValidationError;
use Petlove\Domain\Common\Query\Result;
//use Petlove\Domain\Security\Authorization\BackendAuthorization;
//use Petlove\Domain\Security\Exception\AuthenticationError;
//use Petlove\Domain\Security\Exception\AuthorizationError;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BackendUserService
{
    /**
     * @var BackendUserRepository
     */
    private $backendUserRepo;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * BackendUserService constructor.
     *
     * @param BackendUserRepository $backendUserRepo
     * @param ValidatorInterface    $validator
     */
    public function __construct(
        BackendUserRepository $backendUserRepo,
        ValidatorInterface $validator
    ) {
        $this->backendUserRepo = $backendUserRepo;
        $this->validator = $validator;
    }

    /**
     * @param CreateBackendUser    $cmd
     *
     * @return BackendUserId
     */
//    public function create(BackendAuthorization $authorization, CreateBackendUser $cmd)
    public function create(CreateBackendUser $cmd)
    {
//        if ($authorization->isAnonymous()) {
//            throw new AuthenticationError();
//        }
//        if (!$authorization->canCreateBackendUsers()) {
//            throw new AuthorizationError();
//        }
        if (count($violations = $this->validator->validate($cmd)) > 0) {
            throw new ValidationError($violations);
        }

        return $this->backendUserRepo->create($cmd);
    }

    /**
     * @param UpdateBackendUser    $cmd
     */
//    public function update(BackendAuthorization $authorization, UpdateBackendUser $cmd)
    public function update(UpdateBackendUser $cmd)
    {
//        if ($authorization->isAnonymous()) {
//            throw new AuthenticationError();
//        }
//        if (!$authorization->canUpdateBackendUsers()) {
//            throw new AuthorizationError();
//        }
        if (count($violations = $this->validator->validate($cmd)) > 0) {
            throw new ValidationError($violations);
        }

        return $this->backendUserRepo->update($cmd);
    }

    /**
     * @param DeleteBackendUser    $cmd
     */
//    public function delete(BackendAuthorization $authorization, DeleteBackendUser $cmd)
    public function delete(DeleteBackendUser $cmd)
    {
//        if ($authorization->isAnonymous()) {
//            throw new AuthenticationError();
//        }
//
//        if (!$authorization->canDeleteBackendUsers()) {
//            throw new AuthorizationError();
//        }

        if (count($violations = $this->validator->validate($cmd)) > 0) {
            throw new ValidationError($violations);
        }

//        if ($authorization->getUser() && $cmd->getId()->equals($authorization->getUser()->getId())) {
//            throw new AuthorizationError('Cannot delete itself');
//        }

        return $this->backendUserRepo->delete($cmd->getId());
    }

    /**
     * @param mixed                $filter
     * @param Page|null            $page
     *
     * @return BackendUser[]|Result
     */
//    public function query(BackendAuthorization $authorization, $filter = null, Page $page = null)
    public function query($filter = null, Page $page = null)
    {
//        if ($authorization->isAnonymous()) {
//            throw new AuthenticationError();
//        }
//        if (!$authorization->canAccessBackendUsers()) {
//            throw new AuthorizationError('Only super admins can access backend users.');
//        }

        return $this->backendUserRepo->query($filter, $page);
    }

    public function find(BackendUserId $userId)
    {
//        if ($authorization->isAnonymous()) {
//            throw new AuthenticationError();
//        }
//        if (!$authorization->canAccessBackendUsers()) {
//            throw new AuthorizationError('Only super admins can access backend users.');
//        }

        return $this->backendUserRepo->get($userId);
    }
}
