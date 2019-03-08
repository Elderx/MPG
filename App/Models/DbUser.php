<?php
/**
 * Created by PhpStorm.
 * User: php_r
 * Date: 6.3.2019
 * Time: 1.24
 */

namespace App\Models;


use DB\SQL\Schema;

/**
 * @property string name
 * @property string password
 * @property string email
 * @property int    power
 */
class DbUser extends \DB\Cortex
{
    protected $db = 'DB';
    protected $table = 'users';
    protected $fieldConf =
        [
            'name' => ["type" => Schema::DT_VARCHAR256, "nullable" => false],
            'email' => ["type" => Schema::DT_VARCHAR128, "index" => true, "unique" => true],
            'password' => ["type" => Schema::DT_VARCHAR256, "nullable" => false],
            'power' => ["type" => Schema::DT_TINYINT, "default" => 0],
        ];

}