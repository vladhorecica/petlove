<?php

namespace Petlove\CliBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
//use Tests\System\TearDownTest;

class ResetDataCommand extends ContainerAwareCommand
{
//    use TearDownTest;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('petlove:ResetData');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion(
            'WARNING: This will delete master and tenant related databases.'.
            'Are you sure you want to continue ? (y/N)',
            false
        );

        if (!$helper->ask($input, $output, $question)) {
            return;
        }

        $this->destroy($this->getContainer());

        $masterDbName = $this->getContainer()->getParameter('database_name');
        $this->getContainer()->get('mysql_connection')->rawQuery("DROP DATABASE {$masterDbName};");
        $this->getContainer()->get('mysql_connection')->rawQuery("CREATE DATABASE {$masterDbName};");
        $this->getContainer()->get('mysql_connection')->rawQuery("USE {$masterDbName};");
        $this->getContainer()->get('petlove.migration_service')->migrateMaster($output);
    }
}
