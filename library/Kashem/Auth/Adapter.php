<?php

class Kashem_Auth_Adapter implements Zend_Auth_Adapter_Interface {

    protected $_username;
    protected $_password;

    public function __construct($username, $password) {
        $this->_username = $username;
        $this->_password = $password;
    }

    public function authenticate() {
        $usuariosf = new Kashem_Model_UsuariosfMapper();
        $user = $usuariosf->fetchOneByNameAndPassword($this->_username, $this->_password);
        if ($user != null) {
            $identity = (object) array('userId' => $user->getId(),
                        'username' => $user->getNombre(),
                        'name' => $user->getNombre(),
                        'role' => "admin");
            return new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, $identity);
        }
        return new Zend_Auth_Result(Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID, $this->_username);
    }

}
