<?php
/**
 * File Name: Request.php
 * @author Ondřej Koubek
 * Date: 16.01.2022
 * Time: 19:37
 */

namespace koubeko\phpmvc;

use JetBrains\PhpStorm\Pure;

/**
 * Class Request
 *
 * @author Ondřej Koubek
 * @namespace koubeko\phpmvc
 */
class Request
{
    public function getPath(): string
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        if ($position === false) {
            return $path;
        }
        return substr($path, 0, $position);
    }

    public function method(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    #[Pure] public function isGet(): bool
    {
        return $this->method() === 'get';
    }

    #[Pure] public function isPost(): bool
    {
        return $this->method() === 'post';
    }

    #[Pure] public function getBody(): array
    {
        $body = [];
        if ($this->method() === 'get') {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }
        }
        if ($this->method() === 'post') {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }
        }
        return $body;
    }
}