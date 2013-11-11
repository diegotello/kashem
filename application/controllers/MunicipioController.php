<?php

class MunicipioController extends Zend_Controller_Action {

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
            $dm = new Kashem_Model_DepartamentoMapper();
            $mm = new Kashem_Model_MunicipioMapper();
            $departamento = new Kashem_Model_Departamento();
            $dm->find($request->getParam('departamento_id'), $departamento);
            $this->view->municipios = $mm->fetchAllByDepartamento($departamento);
            $this->_helper->json(array('lista' => $this->view->render('municipio/lista.phtml')));
        }
    }

}

