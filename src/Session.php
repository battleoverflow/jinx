<?php
/*
    Project: Jinx Framework (https://github.com/azazelm3dj3d/jinx)
    License: BSD 2-Clause

    Author: azazelm3dj3d (https://github.com/azazelm3dj3d)
*/

namespace Jinx;

class Session
{
    protected const FLASH_KEY = "flash_messages";

    public function __construct()
    {
        session_start();
        $flash_messages = $_SESSION[self::FLASH_KEY] ?? [];

        // Iterates over the flash messages and sets to true for removal
        // The flash message is removed during reload, but should be present throughout the current session
        foreach ($flash_messages as $key => &$flash_message) {
            $flash_message['remove'] = true;
        }

        $_SESSION[self::FLASH_KEY] = $flash_messages;
    }

    public function setFlash($key, $message)
    {
        // Creates a flash message based on the status of submitted request
        $_SESSION[self::FLASH_KEY][$key] = [
            "remove" => false,
            "value" => $message
        ];
    }

    public function getFlash($key)
    {
        // Get the flash message value
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    public function remove($key)
    {
        unset($_SESSION[$key]);
    }

    public function __destruct()
    {
        $flash_messages = $_SESSION[self::FLASH_KEY] ?? [];

        // If the session is set to true, it destroys the variable
        foreach ($flash_messages as $key => &$flash_message) {
            if ($flash_message['remove']) {
                unset($flash_messages[$key]);
            }
        }

        $_SESSION[self::FLASH_KEY] = $flash_messages;
    }
}

?>