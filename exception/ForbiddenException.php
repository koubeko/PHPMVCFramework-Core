<?php
/**
 * File Name: ForbiddenException.php
 * @author Ondřej Koubek
 * Date: 28.01.2022
 * Time: 10:05
 */

namespace app\core\exception;

/**
 * Class ForbiddenException
 *
 * @author Ondřej Koubek
 * @namespace app\core\exception
 */
class ForbiddenException extends \Exception
{
    protected $message = 'You do not have permission to access this page';
    protected $code = 403;
}