<?php

class Kashem_Auth_Adapter implements Zend_Auth_Adapter_Interface {

    protected $_username;
    protected $_password;

    public function __construct($username, $password) {
        $this->_username = $username;
        $this->_password = $password;
    }

    public function authenticate() {
        /*
          $userRepo = $this->_em->getRepository('Kashem\Entity\User');
          $user = $userRepo->findOneBy(array('username' => $this->_username));

          if ($user != null)
          {
          $salt = $user->getSalt();
          $userProfile = $user->getUserProfile();
          $firstName = $userProfile != null ? $userProfile->getFirstName()
          : $this->email;
          if (sha1($salt.$this->_password) == $user->getPassword())
          {
          $identity = (object)array('userId' => $user->getId(),
          'username' => $user->getUsername(),
          'name' => $firstName,
          'role' => $user->getRole()->getName());

          return new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, $identity);
          }
          }
          return new Zend_Auth_Result(Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID, $this->_username);

         */
        $identity = (object) array('userId' => 1,
                    'username' => "temp",
                    'name' => "temp",
                    'role' => "admin");

        return new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, $identity);
    }

}
