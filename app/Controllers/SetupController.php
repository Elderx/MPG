<?php
/**
 * Created by PhpStorm.
 * Date: 5.3.2019
 * Time: 13.31
 */

namespace App\Controllers;

use DB\SQL;
use PDOException;

class SetupController extends Controller
{
    protected $layout = "templates/setup.htm";

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

    }

    public function getIndex($f3)
    {
        $content = "setup/index.htm";
        $token = $this->getToken();
        $sqlValues = $f3->get("SESSION.sqlValues") ?: [
            "DB_HOST" => "127.0.0.1",
            "DB_PORT" => 3306,
            "DB_USER" => "",
            "DB_PASS" => "",
            "DB_DATABASE" => "",
        ];

        $this->view(compact("content", "token", "sqlValues"));
    }

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
            "DB_PASS" => $pass,
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
            file_put_contents(APP_ROOT."/.env", $out);
            $this->redirect("/");
        } catch (PDOException $ex) {

            $this->flash($ex->getMessage(), "error");
            $this->redirect("/");
        }
    }

}
