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
        $alquiler = $cm->fetchAllAlquilerAsArray();
        $viaje = $cm->fetchAllAsArray('viaje');
        $this->view->data = json_encode($cuentas);
        $this->view->alquiler_data = json_encode($alquiler);
        $this->view->viaje_data = json_encode($viaje);
    }

    public function viajesAction() {
        $vm = new Kashem_Model_ViajeMapper();
        $vdm = new Kashem_Model_ViajeDestinoMapper();
        $vam = new Kashem_Model_ViajeActividadMapper();
        $gvm = new Kashem_Model_GuiaViajeMapper();
        $viajes = $vm->fetchAllAsArray();
        $destinos = $vdm->fetchAllAsArray();
        $actividades = $vam->fetchAllAsArray();
        $guias = $gvm->fetchAllAsArray();
        $this->view->data = json_encode($viajes);
        $this->view->destinos_data = json_encode($destinos);
        $this->view->actividades_data = json_encode($actividades);
        $this->view->guias_data = json_encode($guias);
    }

}

