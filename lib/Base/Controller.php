<?php

namespace Lib\Base;

use Lib\Session;
use App\Models\User;

/**
 * Controller
 */
class Controller
{

    protected $view;

    public function view($view_name, $data = [])
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
