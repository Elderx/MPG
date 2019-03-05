<?php
/**
 * Created by PhpStorm.
 * User: php_r
 * Date: 5.3.2019
 * Time: 18.08
 */

namespace App;


class Router
{
    /**
     * @param \Base $f3
     */
    public static function Routes($f3)
    {
        $f3->route('GET /', "\App\Controllers\IndexController->getIndex");
        $f3->route('GET /test/test', "\App\Controllers\IndexController->getIndex");
    }
}