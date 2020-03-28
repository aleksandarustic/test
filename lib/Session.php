<?php

namespace Lib;

/**
 * Session
 */
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
     */
    public static function destroy()
    {
        session_destroy();
    }

    /**
     * exists: Check if session item exists
     *
     * @param  mixed $name
     * @return void
     */
    public static function exists($name)
    {
        return (isset($_SESSION[$name])) ? true : false;
    }

    /**
     * get: Get item from session
     *
     * @param  mixed $name
     * @return void
     */
    public static function get($name)
    {
        return $_SESSION[$name];
    }

    /**
     * set :Set item in session
     *
     * @param  mixed $name
     * @param  mixed $value
     * @return void
     */
    public static function set($name, $value)
    {
        return $_SESSION[$name] = $value;
    }

    /**
     * delete: delete item from session
     *
     * @param  mixed $name
     * @return void
     */
    public static function delete($name)
    {
        if (self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }

    /**
     * setMessages: add messages to sessions
     *
     * @param  mixed $msg
     * @return void
     */
    public static function setMessages($msg)
    {
        self::set('messages', $msg);
    }

    /**
     * setErrors
     *
     * @param  mixed $errors
     * @return void
     */
    public static function setErrors($errors)
    {
        self::set('errors', $errors);
    }

    /**
     * getMessages: get messages from session
     *
     * @param  mixed $type
     * @return void
     */
    public static function getMessages($type = false)
    {
        if ($type == false) {
            return self::get('messages');
        } else {
            return  isset(self::get('messages')[$type]) ? self::get('messages')[$type] : '';
        }
    }


    /**
     * hasError: Check if session has error
     *
     * @param  mixed $field
     * @return bool
     */
    public static function hasError($field): bool
    {
        return isset(self::getErrors()[$field]) ? true : false;
    }

    /**
     * getErrors : Get error from sessions
     *
     * @param  mixed $field
     * @return void
     */
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
