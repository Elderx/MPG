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
use Symfony\Component\Console\Question\Question;


class CreateUser extends DbCommand
{

    protected static $defaultName = 'admin:create';

    protected function configure()
    {
        $this->setDescription('Creates a new admin user')
            ->setHelp('usage admin:create');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $name = $helper->ask($input, $output, new Question('Username: ', false));
        $email = $helper->ask($input, $output, new Question('Email: ', false));

        $output->writeln("Notice: password will be visible on windows machines!");
        $pass = $helper->ask($input, $output, (new Question('Password: ', false))->setHidden(DIRECTORY_SEPARATOR == "/"));

        $output->writeln("");

        $user = new DbUser();
        $user->name = $name;
        $user->email = $email;
        $user->password =  \password_hash($pass, PASSWORD_BCRYPT);
        $user->power = 3;
        try {
            $user->save();
        } catch (\Exception $ex) {
            $output->writeln("<error>error while creating user</error>\n".$ex->getMessage());
            return;
        }

        $output->writeln("user created!");

    }

}