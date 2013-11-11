<?php

class PaisController extends Zend_Controller_Action {

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
            $pm = new Kashem_Model_PaisMapper();
            $this->view->paises = $pm->fetchAll();
            $this->_helper->json(array('lista' => $this->view->render('pais/lista.phtml')));
        }
    }

}

