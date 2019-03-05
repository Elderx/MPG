<?php
/**
 * Created by PhpStorm.
 * User: php_r
 * Date: 5.3.2019
 * Time: 18.04
 */

namespace App;

use App\Controllers\ErrorController;
use Symfony\Component\Dotenv\Dotenv;

class Bootstrapper
{

    /**
     * @param \Base $f3
     */
    public function __construct($f3)
    {

        $f3->set('ONERROR',
            function ($f3) {
                /**
                 * @var \Base $f3
                 */
                // recursively clear existing output buffers:
                while (ob_get_level()) {
                    ob_end_clean();
                }
                $error =  new ErrorController($f3);
                if ($f3->get("ERROR.code") == 404) {
                   $error->get404();
                    return;
                } else {
                    $error->getGeneric();
                    return;
                }
            });

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