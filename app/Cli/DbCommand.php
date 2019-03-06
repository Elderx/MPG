<?php
/**
 * Created by PhpStorm.
 * User: php_r
 * Date: 6.3.2019
 * Time: 16.29
 */

namespace App\Cli;


use DB\SQL;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Dotenv\Dotenv;

abstract class DbCommand extends Command
{

    /** @var \Base */
    protected $f3;

    public function __construct($name = null)
    {
        parent::__construct($name);
        $f3 = \Base::instance();

        $dotenv = new Dotenv();
        $dotenv->load(APP_ROOT.'/../.env');
        $this->connectDb($f3);
    }

    /**
     * @param \Base $f3
     */
    private function connectDb($f3)
    {

        try {
            $db = new SQL('mysql:host='.getenv("DB_HOST").';port='.getenv("DB_PORT").';dbname='.getenv("DB_DATABASE").';',
                getenv("DB_USER"), getenv("DB_PASS"));

            $f3->set("DB", $db);

        } catch (\PDOException $ex) {
            echo "error :".$ex->getMessage();
            exit(1);
        }
    }


}