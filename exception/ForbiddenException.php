<?php
/**
 * File Name: ForbiddenException.php
 * @author Ondřej Koubek
 * Date: 28.01.2022
 * Time: 10:05
 */

namespace koubeko\phpmvc\exception;

/**
 * Class ForbiddenException
 *
 * @author Ondřej Koubek
 * @namespace koubeko\phpmvc\exception
 */
class ForbiddenException extends \Exception
{
    protected $message = 'You do not have permission to access this page';
    protected $code = 403;
}