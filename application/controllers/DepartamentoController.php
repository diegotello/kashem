<?php

class DepartamentoController extends Zend_Controller_Action {

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
            $dm = new Kashem_Model_DepartamentoMapper();
            $pais = new Kashem_Model_Pais();
            $pm->find($request->getParam('pais_id'), $pais);
            $this->view->departamentos = $dm->fetchAllByPais($pais);
            $this->_helper->json(array('lista' => $this->view->render('departamento/lista.phtml')));
        }
    }

}

