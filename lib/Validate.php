<?php

namespace Lib;

/**
 * Validate Class
 */
class Validate
{
    /**
     * _passed : true if everythis is ok
     *
     * @var bool
     */
    private $_passed = false;
    /**
     * _errors
     *
     * @var array
     */
    private $_errors = [];

    /**
     * check: check input and add error if exists
     *
     * @param  mixed $source
     * @param  mixed $items
     * @return void
     */
    public function check($source, $items = [])
    {
        $this->_errors = [];
        $this->_passed = true;

        foreach ($items as $item => $rules) {
            $item = Input::sanitize($item);
            $display = $rules['display'];
            foreach ($rules as $rule => $rule_value) {
                $value = Input::sanitize(trim($source[$item]));
                if ($rule == 'required' && empty($value)) {
                    $this->addError(["{$display} is required"], $item);
                } else if ($rule == 'email' && !empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError(["{$display} must be a valid email address."], $item);
                }
            }
        }
    }

    /**
     * addError: add error to instance
     *
     * @param  mixed $error
     * @param  mixed $item
     * @return void
     */
    public function addError($error, $item)
    {
        $this->_errors[$item] = $error;
        if (empty($this->_errors)) {
            $this->_passed = true;
        } else {
            $this->_passed = false;
        }
    }

    /**
     * errors: return errors
     *
     * @return void
     */
    public function errors()
    {
        return $this->_errors;
    }

    /**
     * passed: return passes state
     *
     * @return void
     */
    public function passed()
    {
        return $this->_passed;
    }
}
