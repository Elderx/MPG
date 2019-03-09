<?php
/**
 * Created by PhpStorm.
 * Date: 5.3.2019
 * Time: 13.31
 */

namespace App\Controllers;

class AdminController extends Controller
{
    protected $layout = "templates/layout.htm";

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Landing page
     * @param \Base $f3
     */
    public function getDashboard($f3)
    {
        $this->view("admin/dashboard.htm");
    }

    /**
     * upload page
     * @param \Base $f3
     */
    public function getUpload($f3)
    {
        $this->view("admin/upload.htm");
    }

}