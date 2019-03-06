<?php
/**
 * Created by PhpStorm.
 * Date: 5.3.2019
 * Time: 13.32
 */

namespace App\Controllers;

abstract class Controller
{
    /** @var string $layout */
    protected $layout = "templates/layout.htm";

    /** @var \Session */
    protected $session;


    public function __construct()
    {
        /** @var \Base $f3 */
        $f3 = \Base::instance();

        // set base url for html base tag
        $f3->set("base_url", $f3->SCHEME.'://'.$f3->HOST.':'.$f3->PORT.$f3->BASE.'/');

        // automatic csrf validation
        if ($f3->VERB == 'POST') {
            $token = $f3->get('POST.token');
            $csrf = $f3->get('SESSION.csrf');
            if (empty($token) || empty($csrf) || $token !== $csrf) {
                $this->redirect("error/csrf");
            }
        }
    }

    public function flash($message, $type = "info")
    {
        \Base::instance()->set("SESSION.flash", [$type, $message]);
    }

    /**
     * render view
     * @param string $resource
     * @param array $variables
     */
    public function view($resource, $variables = [])
    {
        $f3 = \Base::instance();
        // add variables
        $f3->set("content", $resource);

        foreach ($variables as $key => $value) {
            $f3->set($key, $value);
        }
        // add flash support
        if ($f3->get("SESSION.flash")) {
            $f3->set("flashMessage", $f3->get("SESSION.flash"));
            $f3->set("SESSION.flash", false);
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
        \Base::instance()->reroute($to, false);
    }

    /** Generate a new csrf token */
    public function getToken()
    {
        $token =\Base::instance()->get("session")->csrf();
        \Base::instance()->copy('CSRF', 'SESSION.csrf');

        return $token;
    }

}
