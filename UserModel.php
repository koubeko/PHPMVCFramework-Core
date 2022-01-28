<?php
/**
 * File Name: UserModel.php
 * @author Ondřej Koubek
 * Date: 28.01.2022
 * Time: 8:48
 */

namespace app\core;

use app\core\db\DBModel;

/**
 * Class UserModel
 *
 * @author Ondřej Koubek
 * @namespace app\core
 */
abstract class UserModel extends DBModel
{
    abstract public function getDisplayName(): string;
}