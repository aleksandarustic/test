<?php

namespace Lib;

class Validate
{
    private $_passed = false;
    private $_errors = [];

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

    public function addError($error, $item)
    {
        $this->_errors[$item] = $error;
        if (empty($this->_errors)) {
            $this->_passed = true;
        } else {
            $this->_passed = false;
        }
    }

    public function errors()
    {
        return $this->_errors;
    }

    public function passed()
    {
        return $this->_passed;
    }
}
