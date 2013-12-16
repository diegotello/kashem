<?php

class ReporteController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        $this->_helper->_layout->setLayout('report_layout');
    }

    public function indexAction() {
        // action body
    }

    public function clientesAction() {
        $cm = new Kashem_Model_ClienteMapper();
        $clm = new Kashem_Model_ClienteLogroMapper();
        $cvm = new Kashem_Model_ClienteViajeMapper();
        $am = new Kashem_Model_AlquilerMapper();
        $clientes = $cm->fetchAllAsArray();
        $logros = $clm->fetchAllAsArray();
        $viajes = $cvm->fetchAllAsArray();
        $alquiler = $am->fetchAllAsArray();
        $this->view->data = json_encode($clientes);
        $this->view->logros_data = json_encode($logros);
        $this->view->viajes_data = json_encode($viajes);
        $this->view->alquiler_data = json_encode($alquiler);
    }

    public function cuentasAction() {
        $cm = new Kashem_Model_CuentaMapper();
        $cuentas = $cm->fetchAllAsArray();
        $this->view->data = json_encode($cuentas);
    }

}

