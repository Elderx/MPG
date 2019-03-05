<?php
/**
 * Created by PhpStorm.
 * Date: 5.3.2019
 * Time: 13.24
 */

require("vendor/autoload.php");

use Symfony\Component\Dotenv\Dotenv;

define("APP_VERSION", "0.1");
define("APP_ROOT", __DIR__);

$f3 = \Base::instance();
$f3->set('DEBUG', 1);
$f3->set("UI", "view/");

new \App\Bootstrapper($f3);