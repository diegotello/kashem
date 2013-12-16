<?php

class ReporteController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        // action body
    }

    public function clientesAction() {
        $cm = new Kashem_Model_ClienteMapper();
        $clientes = $cm->fetchAllAsArray();
        $this->view->data = json_encode($clientes);
    }

    public function cuentasAction() {
        $cm = new Kashem_Model_CuentaMapper();
        $cuentas = $cm->fetchAllAsArray();
        $this->view->data = json_encode($cuentas);
    }

}

