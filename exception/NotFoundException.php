<?php
/**
 * File Name: NotFoundException.php
 * @author Ondřej Koubek
 * Date: 28.01.2022
 * Time: 10:40
 */

namespace koubeko\phpmvc\exception;

/**
 * Class NotFoundException
 *
 * @author Ondřej Koubek
 * @namespace koubeko\phpmvc\exception
 */
class NotFoundException extends \Exception
{
    protected $message = 'Page not found';
    protected $code = 404;
}