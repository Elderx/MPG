<?php
/**
 * Created by PhpStorm.
 * Date: 5.3.2019
 * Time: 13.31
 */

namespace App\Controllers;

use App\Models\DbUser;

class AuthController extends Controller
{
    protected $layout = "templates/simple.htm";

    /**
     * Landing page
     * @param \Base $f3
     */
    public function getLogin($f3)
    {
        $token = $this->getToken();
        $f3->set("SESSION.user", false);
        $this->view("auth/login.htm", compact("token"));
    }

    /**
     * @param \Base $f3
     */
    public function postLogin($f3)
    {
        $error = false;

        $user = new DbUser();
        $user->load(["email = ?", $this->postParam("email", null)]);

        if ($user->dry()) {
            $error = true;
        }

        if (!password_verify($this->postParam("password"), $user->password)) {
            $error = true;
        }

        if ($error) {
            $f3->set("SESSION.user", false);
            $this->flash("your credentials doens\'t match", "error");
            $this->redirect("/auth/login");

            return;
        }

        // set session user
        $userArray = $user->cast(null, 2);
        unset($userArray['password']);
        $f3->set("SESSION.user", (object) $userArray);

        $this->redirect($f3->get("SESSION.redirect") ?: "/");
    }

    /**
     * @param \Base $f3
     */
    public function getLogout($f3)
    {
        $f3->set("SESSION.user", false);
        $f3->set("SESSION.redirect", "/");

        $this->redirect("/");
    }

}