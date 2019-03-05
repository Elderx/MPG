<?php
/**
 * Created by PhpStorm.
 * Date: 5.3.2019
 * Time: 13.32
 */

namespace App\Controllers;

class Controller
{

    public function __construct()
    {

    }

    /**
     * @param array  $variables
     * @param string $layout
     */
    public function view($variables = [], $layout = "templates/layout.htm")
    {
        $f3 = \Base::instance();
        foreach ($variables as $key => $value) {
            $f3->set($key, $value);
        }
        echo \Template::instance()->render($layout);
    }

    /**
     * @param string $param query string parameter
     * @return mixed
     */
    public function getParam($param)
    {
        return \Base::instance()->get("GET.".$param);
    }

}
