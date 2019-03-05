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
    public function getCsrf()
    {
        $content = "errors/csrf.htm";
        $this->view(compact("content"));
    }

    /**
     * 404
     * @param \Base $f3
     */
    public function get404()
    {
        $content = "errors/e404.htm";
        $this->view(compact("content", "error"));
    }

    /**
     * 404
     * @param \Base $f3
     */
    public function getGeneric()
    {
        $content = "errors/generic.htm";
        $errorMessage = \Base::instance()->get('ERROR.text');
        $this->view(compact("content", "errorMessage"));
    }

}