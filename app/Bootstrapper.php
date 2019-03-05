<?php
/**
 * Created by PhpStorm.
 * User: php_r
 * Date: 5.3.2019
 * Time: 18.04
 */

namespace App;

class Bootstrapper
{

    public function __construct()
    {
        echo Config::instance()->test;

        $f3 = \Base::instance();
        $f3->set('DEBUG', 1);
        $f3->set("UI", "view/");

        Router::Routes($f3);

        $f3->run();

    }
}