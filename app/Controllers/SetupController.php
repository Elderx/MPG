<?php
/**
 * Created by PhpStorm.
 * Date: 5.3.2019
 * Time: 13.31
 */

namespace App\Controllers;

use App\Models\DbUser;
use DB\SQL;
use PDOException;

class SetupController extends Controller
{
    protected $layout = "templates/setup.htm";

    /** @param \Base $f3 */
    public function getSqlSetup($f3)
    {
        $token = $this->getToken();
        $sqlValues = $f3->get("SESSION.sqlValues") ?: [
            "DB_HOST" => "127.0.0.1",
            "DB_PORT" => 3306,
            "DB_USER" => "",
            "DB_PASS" => "",
            "DB_DATABASE" => "",
        ];

        $this->view("setup/sql.htm", compact("token", "sqlValues"));
    }

    /** @param \Base $f3 */
    public function postSqlSetup($f3)
    {

        $host = $this->postParam("DB_HOST", "127.0.0.1");
        $port = $this->postParam("DB_PORT", 3306);
        $user = $this->postParam("DB_USER", "root");
        $pass = $this->postParam("DB_PASS", null);
        $database = $this->postParam("DB_DATABASE", "f3");

        $f3->set("SESSION.sqlValues", [
            "DB_HOST" => $host,
            "DB_PORT" => $port,
            "DB_USER" => $user,
            "DB_PASS" => "",
            "DB_DATABASE" => $database,
        ]);

        $out = "";
        $out .= "DB_HOST=".$host."\n";
        $out .= "DB_PORT=".$port."\n";
        $out .= "DB_USER=".$user."\n";
        $out .= "DB_PASS=".$pass."\n";
        $out .= "DB_DATABASE=".$database."\n";

        try {
            $db = new SQL('mysql:host='.$host.';port='.$port.';dbname='.$database.';', $user, $pass);
            $db->version();

            // create .env
            file_put_contents(APP_ROOT."/.env", $out);

            // reset session values
            $f3->set("SESSION.sqlValues", []);
            $f3->set("SESSION.setup", true);

            // redirect to step 2
            $this->redirect("/step2");
        } catch (PDOException $ex) {

            $this->flash($ex->getMessage(), "error");

            // since .env file is not yet available, this will return to sql setup
            $this->redirect("/");
        }
    }

    /** @param \Base $f3 */
    public function getUserSetup($f3)
    {
        $token = $this->getToken();
        try {
            DbUser::setup();
        } catch (\Exception $exception) {
            $this->flash($exception->getMessage(), "error");
        }

        $userValues = $f3->get("SESSION.userValues") ?: [
            "name" => null,
            "email" => null,
        ];

        $this->view("setup/user.htm", compact("token"));
    }

    /** @param \Base $f3 */
    public function postUserSetup($f3)
    {
        $name = $this->postParam("name", null);
        $email = $this->postParam("email", null);
        $pass1 = $this->postParam("password1", null);
        $pass2 = $this->postParam("password2", null);

        if ($name !== null) {
            $this->flash("You must provide a name", "error");
            $this->redirect("/step2");

            return;
        }

        if ($email !== null) {
            $this->flash("You must provide a valid email", "error");
            $this->redirect("/step2");

            return;
        }

        if (($pass1 !== null && $pass2 !== null) && $pass1 !== $pass2) {
            $f3->set("SESSION.userValues", ["name" => $name, "email" => $email]);
            $this->flash("Passwords not match", "error");
            $this->redirect("/step2");

            return;
        }

        // create user
        $user = new DbUser();
        $user->name = $name;
        $user->email = $email;
        $user->password = \password_hash($pass1, PASSWORD_BCRYPT);
        $user->power = 2;
        $user->save();

        // end setup
        $f3->set("SESSION.setup", false);

        $this->redirect("/");
    }

}
