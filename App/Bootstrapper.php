<?php
/**
 * Created by PhpStorm.
 * User: php_r
 * Date: 5.3.2019
 * Time: 18.04
 */

namespace App;

use App\Controllers\ErrorController;
use DB\SQL;
use Dotenv\Dotenv;
use Middleware;


class Bootstrapper
{

    /**
     * @param \Base $f3
     */
    public function __construct($f3)
    {
        // Session cache
        $sessionCache = new \Cache('folder=tmp/sessions/');
        $f3->set("session", new \Session(null, 'CSRF', $sessionCache));

        // set authenticated user for templates
        $f3->set("authUser", $f3->get("SESSION.user"));

        // check if settings exists
        if (file_exists(".env")) {
            $dotenv = Dotenv::create(APP_ROOT);
            $dotenv->load();
            $this->connectDb($f3);
        } else {
            // enter setup mode
            touch(APP_ROOT."/tmp/.setup");
        }

        if (file_exists(APP_ROOT."/tmp/.setup")) {
            Router::Setup($f3);
        } else {
            Router::Routes($f3);
        }

        Middleware::instance()->run();
        $f3->run();

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
            $error = new ErrorController();

            $error->getGeneric($f3, $ex);
            exit(1);
        }
    }

}