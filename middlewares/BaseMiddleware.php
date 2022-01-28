<?php
/**
 * File Name: BaseMiddleware.php
 * @author Ondřej Koubek
 * Date: 28.01.2022
 * Time: 9:51
 */

namespace app\core\middlewares;

/**
 * Class BaseMiddleware
 *
 * @author Ondřej Koubek
 * @namespace app\core\middlewares
 */
abstract class BaseMiddleware
{
    abstract public function execute();
}