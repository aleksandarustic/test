<?php

namespace Lib\Base;

/**
 * Base view Class
 */
class View
{
    /**
     * view_name
     *
     * @var string
     */
    protected $view_name;

    /**
     * data
     *
     * @var array
     */
    protected $data;

    /**
     * site_title
     *
     * @var string
     */
    protected $site_title = SITE_TITLE;

    /**
     * layout
     *
     * @var string
     */
    protected $layout = DEFAULT_LAYOUT;

    /**
     * output_buffer
     *
     * @var mixed
     */
    protected $output_buffer;

    /**
     * errors
     *
     * @var array
     */
    protected $errors;

    /**
     * messages
     *
     * @var array
     */
    protected $messages;

    /**
     * __construct
     *
     * @param  mixed $view_name
     * @param  mixed $data
     * @return void
     */
    public function __construct($view_name, $data)
    {
        $this->view_name = $view_name;
        $this->data = $data;
    }

    /**
     * Require Layout and view into application
     *
     * @return void
     */
    public function render()
    {
        if (file_exists('../resources/views/' . $this->view_name . '.phtml')) {
            include_once '../resources/views/' . $this->view_name . '.phtml';
            include_once '../resources/views/layouts/' . $this->layout . '.phtml';
        } else {
            die("THERE IS NO VIEW");
        }
    }

    /**
     * setLayout
     *
     * @param  mixed $path
     * @return void
     */
    public function setLayout($path)
    {
        $this->layout = $path;
    }

    /**
     * setTitle
     *
     * @param  mixed $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->site_title = $title;
    }
    /**
     * setErrors
     *
     * @param  mixed $errors
     * @return void
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }
    /**
     * setMessages
     *
     * @param  mixed $messages
     * @return void
     */
    public function setMessages($messages)
    {
        $this->messages = $messages;
    }

    /**
     * getSiteTitle
     *
     * @return void
     */
    public function getSiteTitle()
    {
        return $this->site_title;
    }

    /**
     * content
     *
     * @param  mixed $type
     * @return void
     */
    public function content($type)
    {
        return isset($this->{$type}) ? $this->{$type} : '';
    }

    /**
     * getter for data passed by controller
     *
     * @return void
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * get item from data if exists
     *
     * @param  mixed $name
     * @return mixed
     */
    public function item($name)
    {
        return isset($this->data[$name]) ? $this->data[$name] : false;
    }

    /**
     * start buffer loading
     *
     * @param  mixed $type
     * @return void
     */
    public function start($type)
    {
        $this->output_buffer  = $type;
        ob_start();
    }

    /**
     * print buffer output in page
     *
     * @return void
     */
    public function end()
    {
        $this->{$this->output_buffer} = ob_get_clean();
    }
}
