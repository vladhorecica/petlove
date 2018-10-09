<?php

namespace Petlove\CliBundle\Command;

use Petlove\Domain\BackendUser\Command\CreateBackendUser;
use Petlove\Domain\BackendUser\Value\BackendUserEmail;
use Petlove\Domain\BackendUser\Value\BackendUserType;
use Petlove\Domain\BackendUser\Value\BackendUserUsername;
use Petlove\Domain\Security\Authorization\GodAuthorization;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateAdminBackendUserCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('petlove:CreateAdminBackendUser');
        $this->addArgument('email');
        $this->addArgument('password');
        $this->addArgument('username');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $command = new CreateBackendUser(
            new BackendUserEmail($input->getArgument('email')),
            new BackendUserUsername($input->getArgument('username')),
            $input->getArgument('password'),
            BackendUserType::admin()
        );

        $this->getContainer()->get('petlove.backend_user_service')->create(new GodAuthorization(), $command);
    }
}
