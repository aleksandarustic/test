<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\Comment;

use Lib\Base\Controller;
use Lib\Validate;
use Lib\Input;
use Lib\Router;
use Lib\Session;



class Home extends Controller
{
    public function index()
    {
        $products = Product::find(['order' => 'title', 'limit' => 9]);
        $comments = Comment::find(['conditions' => 'approved = ?', 'bind' => [1], 'order' => 'created_at DESC']);

        $this->view('home/index', ['products' => $products, 'comments' => $comments]);
        $this->view->setTitle('Catalog');
        $this->view->render();
    }

    public function comment()
    {
        $validation = new Validate();
        $validation->check($_POST, [
            'name' => [
                'display' => 'Name',
                'required' => true
            ],
            'email' => [
                'display' => 'Email',
                'required' => true
            ],
            'text' => [
                'display' => 'Text',
                'required' => true
            ],
        ]);
        if ($validation->passed()) {


            Comment::insert(['name' => Input::get('name'), 'email' => Input::get('email'), 'text' => Input::get('text')]);

            Session::set('messages', ['success' => 'Comment has been saved and it should be approve soon']);

            Router::redirect(BASE_URL);
        } else {

            Session::set('messages', ['danger' => 'Please provide require information']);
            Session::set('errors', $validation->errors());

            Router::redirect(BASE_URL . '#comment-form');
        }
    }
}
