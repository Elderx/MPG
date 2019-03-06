<?php
/**
 * Created by PhpStorm.
 * Date: 5.3.2019
 * Time: 13.24
 */

require("vendor/autoload.php");

use App\Controllers\ErrorController;


define("APP_VERSION", "0.1");
define("APP_ROOT", __DIR__);

$f3 = \Base::instance();
$f3->set('DEBUG', 3);
$f3->set("UI", "view/");
$f3->set('ONERROR',
    function ($f3) {
        /**
         * @var \Base $f3
         */
        // recursively clear existing output buffers:
        while (ob_get_level()) {
            ob_end_clean();
        }
        $error = new ErrorController();

        if ($f3->get("ERROR.code") == 404) {
            $error->get404($f3);

            return;
        } else {
            $error->getGeneric($f3);

            return;
        }
    });

new \App\Bootstrapper($f3);