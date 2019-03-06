<?php
/**
 * Created by PhpStorm.
 * Date: 5.3.2019
 * Time: 13.31
 */

namespace App\Controllers;

class IndexController extends Controller
{
    protected $layout = "templates/layout.htm";

    /**
     * Landing page
     * @param \Base $f3
     */
    public function getIndex($f3)
    {

        $arrays = [
            "string1",
            "string2",
        ];

        $this->view("welcome.htm", compact("arrays"));
    }

    /**
     * Testing flash message
     * @param \Base $f3
     */
    public function getTest($f3)
    {
        $this->flash("Testing flash");
        $this->redirect("/");

    }

}