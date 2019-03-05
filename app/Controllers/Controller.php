<?php
/**
 * Created by PhpStorm.
 * Date: 5.3.2019
 * Time: 13.32
 */

namespace App\Controllers;

class Controller
{
    protected $layout = "";
    /** @var \Session */
    protected $session;

    public function __construct()
    {

    }

    /**
     * @param array $variables
     */
    public function view($variables = [])
    {
        $f3 = \Base::instance();
        foreach ($variables as $key => $value) {
            $f3->set($key, $value);
        }
        echo \Template::instance()->render($this->layout);
    }

    /**
     * @param string $param query string parameter
     * @param string $default
     * @return mixed
     */
    public function getParam($param, $default = "")
    {
        return \Base::instance()->get("GET.".$param) ?: $default;
    }

    /**
     * @param string $param parameter
     * @param string $default
     * @return mixed
     */
    public function postParam($param, $default = "")
    {
        return \Base::instance()->get("POST.".$param) ?: $default;
    }

    /**
     * @param string $to
     */
    public function redirect($to)
    {
        $f3 = \Base::instance();
        $f3->reroute($to, false);
    }

}
