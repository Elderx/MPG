<?php
/**
 * Created by PhpStorm.
 * User: php_r
 * Date: 6.3.2019
 * Time: 16.14
 */

namespace App\Cli;

use App\Models\DbUser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;


class WipeDatabase extends Command
{

    protected static $defaultName = 'db:refresh';

    protected function configure()
    {
        $this->setDescription('Wipes and re-creates database structures')
            ->setHelp('Wipes and re-creates database structures');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Really wipe and re-create databases ?', false);

        if ($helper->ask($input, $output, $question)) {
            $output->writeln("removing DbUser");
            DbUser::setdown();
            $output->writeln("migrating DbUser");
            DbUser::setup();
            return;
        }
    }

}