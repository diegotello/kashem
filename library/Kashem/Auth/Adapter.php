<?php

class Kashem_Auth_Adapter implements Zend_Auth_Adapter_Interface {

    protected $_username;
    protected $_password;

    public function __construct($username, $password) {
        $this->_username = $username;
        $this->_password = $password;
    }

    public function authenticate() {
        $usuario = new Kashem_Model_UsuarioMapper();
        $user = $usuario->fetchOneByNameAndPassword($this->_username, $this->_password);
        if ($user != null) {
            $identity = (object) array('id' => $user->getId(),
                        'nombre' => $user->getNombre(),
                        'rol' => $user->getRol()->getDescripcion());
            return new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, $identity);
        }
        return new Zend_Auth_Result(Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID, $this->_username);
    }

}
