<?php

namespace Petlove\CliBundle\Command;

//use Petlove\Domain\Security\Authorization\GodAuthorization;
use Petlove\Infrastructure\Common\Value\DatabaseType;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateDbCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('petlove:MigrateDb')
            ->addOption(
                'rollback',
                'r',
                InputOption::VALUE_NONE,
                'If set, the task will perform a total rollback'
            )
            ->addArgument(
                'type',
                InputArgument::OPTIONAL,
                'master',
                'master'
            );
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $migrationsService = $this->getContainer()->get('petlove.migration_service');
        $isRollback = $input->getOption('rollback');
        $type = new DatabaseType($input->getArgument('type'));

        if ($type->equals(DatabaseType::master())) {
            if ($isRollback) {
                $output->writeln('<info>Rollback master<info>');
                $migrationsService->rollbackMaster($output);

                return;
            }

            $output->writeln('<info>Migrating master<info>');
            $migrationsService->migrateMaster($output);

            return;
        }

        $output->writeln('');
    }
}
