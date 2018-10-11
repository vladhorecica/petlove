<?php

namespace Petlove\Infrastructure\BackendUser;

use Util\MySql\Connection;
use Util\MySql\Util\SelectQueryBuilder;
use Util\Value\Page;
use Petlove\Domain\BackendUser\BackendUser;
use Petlove\Domain\BackendUser\BackendUserRepository;
use Petlove\Domain\BackendUser\Command\CreateBackendUser;
use Petlove\Domain\BackendUser\Command\UpdateBackendUser;
use Petlove\Domain\BackendUser\Value\BackendUserId;
use Petlove\Domain\Common\Exception\NotFoundError;
use Petlove\Domain\Common\Query\Result;
use Petlove\Infrastructure\Common\Cache;
use Petlove\Infrastructure\Common\MysqlResultBuilder;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class MysqlBackendUserRepository implements BackendUserRepository
{
    use MysqlResultBuilder;

    /** @var Connection */
    private $mysql;

    /** @var Cache */
    private $userCache;

    /** @var PasswordEncoderInterface */
    private $passwordEncoder;

    /**
     * MysqlBackendUserRepository constructor.
     *
     * @param Connection               $db
     * @param Cache                    $cache
     * @param PasswordEncoderInterface $passwordEncoder
     */
    public function __construct(Connection $db, Cache $cache, PasswordEncoderInterface $passwordEncoder)
    {
        $this->mysql = $db;
        $this->userCache = $cache;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function create(CreateBackendUser $cmd): BackendUserId
    {
        $id = $this->mysql->insert(
            'backend_users',
            [
                'email' => $cmd->getEmail(),
                'password' => $this->passwordEncoder->encodePassword($cmd->getPassword(), null),
                'type' => $cmd->getType(),
                'username' => $cmd->getUsername(),
                'created_at' => time(),
            ]
        );

        return new BackendUserId($id);
    }

    public function update(UpdateBackendUser $cmd)
    {
        $data = [
            'username' => $cmd->getUsername(),
            'type' => $cmd->getType(),
            'email' => $cmd->getEmail()
        ];

        if ($cmd->getPassword()) {
            $data['password'] = $this->passwordEncoder->encodePassword($cmd->getPassword(), null);
        }

        $this->mysql->update('backend_users', $data, ['id' => $cmd->getId()]);

        $this->userCache->remove($cmd->getId());
    }

    public function find(BackendUserId $id): BackendUser
    {
        return $this->userCache->get($id, function () use ($id) {
            $backendUser = $this->mysql->bufferedQuery('
              SELECT * FROM backend_users bu WHERE id = ?
            ', $id)->fetchRow();

            if (!$backendUser) {
                throw new NotFoundError('No user!');
            }

            $user = (new BackendUserMysqlToDomainMapper())->map($backendUser);

            $this->userCache->set($id, $user);

            return $user;
        });
    }

    public function delete(BackendUserId $id)
    {
        $this->mysql->delete('backend_users', ['id' => $id]);

        $this->userCache->remove($id);
    }

    /**
     * @param mixed     $filter
     * @param Page|null $page
     *
     * @return Result|BackendUser[]
     */
    public function query($filter = null, Page $page = null)
    {
        $query = new SelectQueryBuilder('backend_users bu');
        $queryTranslator = new MysqlBackendUserQueryTranslator();
        $query->andWhere($queryTranslator->translateFilter($filter));
        $query->limit($page);

        $mapper = new BackendUserMysqlToDomainMapper();

        return $this->createResult(
            $this->mysql,
            $query,
            function (array $data) use ($mapper) {
                $user = $mapper->map(
                    $data
                );
                $this->userCache->set($user->getId(), $user);
                return $user;
            }
        );
    }
}
