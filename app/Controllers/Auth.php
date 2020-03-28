<?php

namespace App\Controllers;

use Lib\Base\Controller;
use Lib\Session;
use Lib\Validate;
use Lib\Input;
use Lib\Router;
use App\Models\User;

class Auth extends Controller
{
    public function index()
    {
        \Lib\Auth::checkUnauthenticated();

        $this->view('auth/login');
        $this->view->setTitle('Login');
        $this->view->render();
    }

    public function login()
    {

        \Lib\Auth::checkUnauthenticated();

        $validation = new Validate();
        $validation->check($_POST, [
            'username' => [
                'display' => 'Username is not valid',
                'required' => true
            ],
            'password' => [
                'display' => 'Password is not valid',
                'required' => true
            ],
        ]);
        if ($validation->passed()) {

            $user = User::findFirst(['conditions' => 'username = ?', 'bind' => [Input::get('username')]]);

            if ($user && password_verify(Input::get('password'), $user->password)) {

                Session::set(SESSION_USER, $user->id);

                Session::set('messages', ['success' => 'You successfuly logged in !']);
                Router::redirect(BASE_URL . '/admin');
            } else {
                Session::set('messages', ['danger' => 'Your have entered a wrong password']);
                Router::redirect(BASE_URL . '/auth');
            }
        } else {

            Session::set('errors', $validation->errors());

            Router::redirect(BASE_URL . '/auth');
        }
    }

    /**
     * Logout: Delete session. Returns true if everything is okay,
     * otherwise turns false.
     * @access public
     * @return boolean
     */
    public static function logout()
    {
        // Destroy all data registered to the session.
        Session::destroy();

        Router::redirect(BASE_URL);
    }
}
