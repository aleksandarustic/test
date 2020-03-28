<?php

namespace Lib;

class Session
{

    /**
     * Init: Starts the session.
     * @access public
     * @return void
     * @since 1.0.1
     */
    public static function init()
    {
        // If no session exist, start the session.
        if (session_id() == "") {
            session_start();
        }
    }


    /**
     * Destroy: Deletes the session.
     * @access public
     * @return void
     * @since 1.0.1
     */
    public static function destroy()
    {
        session_destroy();
    }

    public static function exists($name)
    {
        return (isset($_SESSION[$name])) ? true : false;
    }

    public static function get($name)
    {
        return $_SESSION[$name];
    }

    public static function set($name, $value)
    {
        return $_SESSION[$name] = $value;
    }

    public static function delete($name)
    {
        if (self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }

    public static function setMessages($msg)
    {
        self::set('messages', $msg);
    }

    public static function setErrors($errors)
    {
        self::set('errors', $errors);
    }

    public static function getMessages($type = false)
    {
        if ($type == false) {
            return self::get('messages');
        } else {
            return  isset(self::get('messages')[$type]) ? self::get('messages')[$type] : '';
        }
    }

    public static function hasError($field)
    {
        return isset(self::getErrors()[$field]) ? true : false;
    }

    public static function getErrors($field = false)
    {
        if (!self::exists('errors')) return null;
        if ($field == false) {
            return self::get('errors');
        } else {
            return isset(self::get('errors')[$field]) ? self::get('errors')[$field] : '';
        }
    }
}
