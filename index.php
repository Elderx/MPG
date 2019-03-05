<?php
/**
 * Created by PhpStorm.
 * Date: 5.3.2019
 * Time: 13.24
 */

require("vendor/autoload.php");

$f3 = Base::instance();
$f3->set('DEBUG', 3);
$f3->set("UI", "view/");


$f3->route('GET /', "\App\Controllers\IndexController->getIndex");
$f3->route('GET /test/test', "\App\Controllers\IndexController->getIndex");

$f3->run();


/**
 * @param string $layout
 * @param array  $variables
 */
function view($layout, $variables = [])
{
    $f3 = Base::instance();
    foreach ($variables as $key => $value) {
        $f3->set($key, $value);
    }
    echo Template::instance()->render($layout);
}

/**
 * @param $param
 * @return mixed
 */
function getParam($param)
{
    $f3 = Base::instance();

    return $f3->get("GET.".$param);
}
