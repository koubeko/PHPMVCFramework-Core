<?php
/**
 * File Name: BaseMiddleware.php
 * @author Ondřej Koubek
 * Date: 28.01.2022
 * Time: 9:51
 */

namespace koubeko\phpmvc\middlewares;

/**
 * Class BaseMiddleware
 *
 * @author Ondřej Koubek
 * @namespace koubeko\phpmvc\middlewares
 */
abstract class BaseMiddleware
{
    abstract public function execute();
}