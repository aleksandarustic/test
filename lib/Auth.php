<?php

namespace Lib;

/**
 * Auth:
 *
 * @author Andrew Dyer <andrewdyer@outlook.com>
 * @since 1.0.2
 */
class Auth
{

    /**
     * Check Authenticated: Checks to see if the user is authenticated,
     * destroying the session and redirecting to a specific location if the user
     * session doesn't exist.
     * @access public
     * @since 1.0.2
     */
    public static function checkAuthenticated()
    {
        Session::init();
        if (!Session::exists(SESSION_USER)) {
            Session::destroy();
            Router::redirect(BASE_URL);
        }
    }

    /**
     * Check Unauthenticated: Checks to see if the user is unauthenticated,
     * redirecting to a specific location if the user session exist.
     * @access public
     * @param string $redirect
     * @since 1.0.2
     */
    public static function checkUnauthenticated()
    {
        Session::init();
        if (Session::exists(SESSION_USER)) {
            Router::redirect(BASE_URL);
        }
    }
}
