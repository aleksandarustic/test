<?php

namespace Lib\Base;

use Lib\Session;
use App\Models\User;


/**
 * This is base controller of app
 */
class Controller
{


    /**
     * Instance of View Class
     *
     * @var View
     */
    protected $view;


    /**
     * Initialize View Class and return requested view with data
     *
     * @param  mixed $view_name
     * @param  array $data
     * @return View
     */
    public function view($view_name, $data = []): View
    {

        if (Session::exists(SESSION_USER)) {
            $user_id = Session::get(SESSION_USER);
            if ($user = User::findById($user_id)) {
                $data['auth_user'] = $user;
            }
        }

        $this->view = new View($view_name, $data);

        return $this->view;
    }
}
