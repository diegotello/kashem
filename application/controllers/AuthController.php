<?php

class AuthController extends Zend_Controller_Action {

    private function _authenticate($values) {
        $adapter = new Kashem_Auth_Adapter($values['username'], $values['password']);
        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($adapter);

        if ($result->isValid()) {
            $user = $result->getIdentity();
            $auth->getStorage()->write($user);
            return true;
        }
        return false;
    }

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        // action body
    }

    public function loginAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $form = new Kashem_Form_Login();
        $request = $this->getRequest();
        if ($request->isPost()) {
            if (/* $form->isValid($request->getPost()) */true) {
                if (/* $this->_authenticate($form->getValues()) */$this->_authenticate(array('username' => 'temp', 'password' => 'temp'))) {
                    try {
                        /*
                          $em = Zend_Registry::get("doctrine")->getEntityManager();
                          $user = $em->getRepository('\Kashem\Entity\User')->findOneById(Zend_Auth::getInstance()->getIdentity()->userId);
                          $now = new DateTime();
                          $user->setLastLogin($now);
                          $em->persist($user);
                          $em->flush();
                         */
                        $this->_helper->json(array('success' => true, 'info' => 'login'));
                    } catch (Exception $e) {
                        $this->_helper->json(array('success' => false, 'info' => $e->getMessage()));
                    }
                } else {
                    $this->_helper->json(array('success' => false, 'info' => 'User or Password not found.'));
                }
            } else {
                $info = '';
                foreach ($form->getMessages() as $k => $o) {
                    foreach ($o as $m) {
                        $info.='<strong>' . $k . ':</strong> ' . $m . '<br>';
                    }
                }
                $this->_helper->json(array('success' => false, 'info' => $info));
            }
        }
    }

    public function logoutAction() {
        try {
            Zend_Auth::getInstance()->clearIdentity();
            $this->_helper->json(array('success' => true, 'info' => 'logout'));
        } catch (Exception $e) {
            $this->_helper->json(array('success' => false, 'info' => 'logout'));
        }
    }

}

