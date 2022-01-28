<?php
/**
 * File Name: UserModel.php
 * @author Ondřej Koubek
 * Date: 28.01.2022
 * Time: 8:48
 */

namespace koubeko\phpmvc;

use koubeko\phpmvc\db\DBModel;

/**
 * Class UserModel
 *
 * @author Ondřej Koubek
 * @namespace koubeko\phpmvc
 */
abstract class UserModel extends DBModel
{
    abstract public function getDisplayName(): string;
}