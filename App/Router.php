<?php
/**
 * Created by PhpStorm.
 * User: php_r
 * Date: 5.3.2019
 * Time: 18.08
 */

namespace App;


use App\Models\DbUser;
use Middleware;

class Router
{
    /**
     * @param \Base $f3
     */
    public static function Routes($f3)
    {


        $f3->route('GET /', "\App\Controllers\IndexController->getIndex");
        $f3->route('GET /test', "\App\Controllers\IndexController->getTest");

        // admin
        $f3->route('GET /admin', "\App\Controllers\AdminController->getDashboard");
        $f3->route('GET /admin/upload', "\App\Controllers\AdminController->getUpload");

        // auth routes
        $f3->route('GET /auth/login', "\App\Controllers\AuthController->getLogin");
        $f3->route('POST /auth/login', "\App\Controllers\AuthController->postLogin");
        $f3->route('GET /auth/logout', "\App\Controllers\AuthController->getLogout");

        // errors
        $f3->route('GET /error/csrf', "\App\Controllers\ErrorController->getCsrf");

        // protect admin
        Middleware::instance()->before('GET /admin*', function (\Base $f3, $params, $alias) {
            if (!$f3->exists("SESSION.user") || $f3->get("SESSION.user") == false) {
                $f3->set("SESSION.redirect", $params[0]);
                $f3->reroute("/auth/login", false);
            }
        });
    }

    /**
     * @param \Base $f3
     */
    public static function Setup($f3)
    {
        $f3->route('GET /', "\App\Controllers\SetupController->getSqlSetup");
        $f3->route('POST /', "\App\Controllers\SetupController->postSqlSetup");
        $f3->route('GET /step2', "\App\Controllers\SetupController->getUserSetup");
        $f3->route('POST /step2', "\App\Controllers\SetupController->postUserSetup");
        $f3->route('GET /error/csrf', "\App\Controllers\ErrorController->getCsrf");
    }

}
