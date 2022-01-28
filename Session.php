<?php
/**
 * File Name: Session.php
 * @author Ondřej Koubek
 * Date: 27.01.2022
 * Time: 13:35
 */

namespace koubeko\phpmvc;

/**
 * Class Session
 *
 * @author Ondřej Koubek
 * @namespace koubeko\phpmvc
 */
class Session
{
    protected const FLASH_KEY = 'flash_messages';

    public function __construct()
    {
        session_start();
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => &$flashMessage) {
            //Mark to be removed
            $flashMessage['remove'] = true;
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    public function setFlash(string $key, string $message)
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove' => false,
            'value'  => $message
        ];
    }

    public function getFlash(string $key)
    {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    public function set(string $key, mixed $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key): mixed
    {
        return $_SESSION[$key] ?? false;
    }

    public function remove(string $key)
    {
        unset($_SESSION[$key]);
    }

    public function __destruct()
    {
        // Iterate over marked to be removed
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => &$flashMessage) {
            if ($flashMessage['remove']) {
                unset($flashMessages[$key]);
            }
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
}