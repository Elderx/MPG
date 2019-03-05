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

    public function getIndex($f3)
    {
        // echo "params:" . getParam("arg");

        $content = "welcome.htm";
        $arrays = [
            "string1",
            "string2",
        ];

        $this->view(compact("content", "arrays"));
    }

}