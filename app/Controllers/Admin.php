<?php

namespace App\Controllers;

use App\Models\Comment;

use Lib\Base\Controller;
use Lib\Validate;
use Lib\Input;
use Lib\Router;
use Lib\Auth;
use Lib\Session;

class Admin extends Controller
{
    public function index()
    {
        Auth::checkAuthenticated();

        $comments = Comment::find(['order' => 'created_at DESC']);

        $this->view('admin/index', ['comments' => $comments]);
        $this->view->setTitle('Admin Panel');
        $this->view->render();
    }

    public function approve()
    {
        Auth::checkAuthenticated();

        $validation = new Validate();
        $validation->check($_POST, [
            'comment_id' => [
                'display' => 'Id does not exists',
                'required' => true
            ],
        ]);

        if ($validation->passed()) {

            Comment::update(Input::get('comment_id'), ['approved' => 1]);

            Session::set('messages', ['success' => 'Comment has been approved']);

            Router::redirect(BASE_URL . '/admin');
        } else {

            Session::set('messages', ['danger' => 'You have validation errors']);

            Session::set('errors', $validation->errors());

            Router::redirect(BASE_URL . '/admin');
        }
    }
}
