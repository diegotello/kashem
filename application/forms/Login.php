<?php

class Kashem_Form_Login extends Zend_Form {

    public function init() {
        $this->addElement('text', 'username', array(
            'placeholder' => 'Username',
            'filters' => array('StringTrim', 'StringToLower'),
            'validators' => array(
                array('StringLength', false, array(1, 45))
            ),
            'required' => true
        ));

        $this->addElement('password', 'password', array(
            'placeholder' => 'Password',
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(1, 50)),
            ),
            'required' => true
        ));
    }

}

