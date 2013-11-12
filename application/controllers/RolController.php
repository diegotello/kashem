<?php

class RolController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        // action body
    }

    public function listaAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $request = $this->getRequest();
        if ($request->isGet()) {
            $rm = new Kashem_Model_RolMapper();
            $this->view->roles = $rm->fetchAll();
            $this->_helper->json(array('lista' => $this->view->render('rol/lista.phtml')));
        }
    }

}

