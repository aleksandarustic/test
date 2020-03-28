<?php

namespace Lib;

/**
 * Input Class
 */
class Input
{    
    /**
     * Protect from xss attack
     *
     * @param  mixed $dirty
     * @return void
     */
    public static function sanitize($dirty)
    {
        return htmlentities($dirty, ENT_QUOTES, "UTF-8");
    }
    
    /**
     * getter for data from global $_POST and  $_GEt
     *
     * @param  mixed $input
     * @return void
     */
    public static function get($input)
    {
        if (isset($_POST[$input])) {
            return self::sanitize($_POST[$input]);
        } else if (isset($_GET[$input])) {
            return self::sanitize($_GET[$input]);
        }
    }
}
