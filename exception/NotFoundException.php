<?php
/**
 * File Name: NotFoundException.php
 * @author Ondřej Koubek
 * Date: 28.01.2022
 * Time: 10:40
 */

namespace app\core\exception;

/**
 * Class NotFoundException
 *
 * @author Ondřej Koubek
 * @namespace app\core\exception
 */
class NotFoundException extends \Exception
{
    protected $message = 'Page not found';
    protected $code = 404;
}