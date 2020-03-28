<?php

namespace Lib\Base;

class View
{
    protected $view_name;
    protected $data;

    protected $site_title = SITE_TITLE;
    protected $layout = DEFAULT_LAYOUT;
    protected $output_buffer;
    protected $errors;
    protected $messages;

    public function __construct($view_name, $data)
    {
        $this->view_name = $view_name;
        $this->data = $data;
    }

    public function render()
    {
        if (file_exists('../resources/views/' . $this->view_name . '.phtml')) {
            include_once '../resources/views/' . $this->view_name . '.phtml';
            include_once '../resources/views/layouts/' . $this->layout . '.phtml';
        } else {
            die("THERE IS NO VIEW");
        }
    }

    public function setLayout($path)
    {
        $this->layout = $path;
    }

    public function setTitle($title)
    {
        $this->site_title = $title;
    }
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }
    public function setMessages($messages)
    {
        $this->messages = $messages;
    }

    public function getSiteTitle()
    {
        return $this->site_title;
    }

    public function content($type)
    {
        return isset($this->{$type}) ? $this->{$type} : '';
    }

    public function getData()
    {
        return $this->data;
    }

    public function item($name)
    {
        return isset($this->data[$name]) ? $this->data[$name] : false;
    }

    public function start($type)
    {
        $this->output_buffer  = $type;
        ob_start();
    }

    public function end()
    {
        $this->{$this->output_buffer} = ob_get_clean();
    }
}
