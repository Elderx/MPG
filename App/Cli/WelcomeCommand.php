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
use Symfony\Component\Console\Command\HelpCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;


class WelcomeCommand extends Command
{

    protected static $defaultName = '/';

    protected function configure()
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("My PHP Gallery cli helper");

    }

}