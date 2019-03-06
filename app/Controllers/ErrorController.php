<?php
/**
 * Created by PhpStorm.
 * Date: 5.3.2019
 * Time: 13.31
 */

namespace App\Controllers;

class ErrorController extends Controller
{
    protected $layout = "templates/layout.htm";

    /**
     * @param \Base $f3
     */
    public function getCsrf($f3)
    {
        $this->view("errors/csrf.htm");
    }

    /**
     * 404
     * @param \Base $f3
     */
    public function get404($f3)
    {
        $this->view("errors/e404.htm");
    }

    /**
     * 404
     * @param \Base           $f3
     * @param bool|\Exception $exception
     */
    public function getGeneric($f3, $exception = false)
    {
        if ($exception) {
            $errorMessage = $exception->getMessage();
        } else {
            $errorMessage = \Base::instance()->get('ERROR.text');
        }

        $this->view("errors/generic.htm", compact("errorMessage"));
    }

}