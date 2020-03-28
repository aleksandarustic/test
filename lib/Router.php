<?php

namespace Lib;

/**
 * Router
 */

class Router
{
    /**
     * view
     *
     * @var string
     */
    protected static $view;

    /**
     * controller
     *
     * @var string
     */
    protected static $controller = 'Home';

    /**
     * action
     *
     * @var string
     */
    protected static $action = 'index';

    /**
     * params
     *
     * @var array
     */
    protected static $params = [];

    /**
     * Parse Url and call requierd controller 
     *
     * @param  mixed $url
     * @return void
     */
    public static function route($url)
    {

        self::$controller = (isset($url[0]) && $url[0] != '') ? ucfirst($url[0]) : self::$controller;

        array_shift($url);

        self::$action = (isset($url[0]) && $url[0] != '') ? $url[0] : self::$action;

        array_shift($url);

        self::$params = $url;

        $controller_name = "\\App\\Controllers\\" . self::$controller;

        $dispatch = new $controller_name(self::$action);

        if (method_exists($dispatch, self::$action)) {
            call_user_func_array([$dispatch, self::$action], self::$params);
        } else {
            die('Method does not exists in controller ' . $controller_name);
        }
    }

    /**
     * Redirect
     *
     * @param  mixed $url
     * @return void
     */
    public static function redirect($url)
    {
        if (!headers_sent()) {
            header('Location: ' . $url);
            exit;
        } else {
            echo '<script type="text/javascript">';
            echo 'window.location.href="' . $url . '";';
            echo '</script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url=' . $url . '" />';
            echo '</noscript>';
            exit;
        }
    }
}
