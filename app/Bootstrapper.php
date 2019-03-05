<?php
/**
 * Created by PhpStorm.
 * User: php_r
 * Date: 5.3.2019
 * Time: 18.04
 */

namespace App;

use Symfony\Component\Dotenv\Dotenv;

class Bootstrapper
{

    /**
     * @param \Base $f3
     */
    public function __construct($f3)
    {
        if (!file_exists(".env")) {
            Router::Setup($f3);
            $f3->run();
            return;
        }

        $dotenv = new Dotenv();
        $dotenv->load(APP_ROOT.'/.env');

        Router::Routes($f3);
        $f3->run();
    }
}