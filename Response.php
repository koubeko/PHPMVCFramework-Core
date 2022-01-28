<?php
/**
 * File Name: Response.php
 * @author Ondřej Koubek
 * Date: 17.01.2022
 * Time: 19:39
 */

namespace koubeko\phpmvc;

/**
 * Class Response
 *
 * @author Ondřej Koubek
 * @namespace koubeko\phpmvc
 */
class Response
{
    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }

    public function redirect(string $url)
    {
        header('Location: ' . $url);
    }
}