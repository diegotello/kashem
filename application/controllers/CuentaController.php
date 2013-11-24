<?php

class CuentaController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        $cm = new Kashem_Model_CuentaMapper();
        $cuentas = $cm->fetchAll();
        $alquiler_pendientes_html = "";
        $alquiler_canceladas_html = "";
        $viaje_pendientes_html = "";
        $viaje_canceladas_html = "";
        foreach ($cuentas as $c) {
            $this->view->cuenta = $c;
            switch ($c->tipo) {
                case 'alquiler':
                    if ($c->getEstado() == 'pendiente') {
                        $alquiler_pendientes_html .= $this->view->render('cuenta/lista_row_alquiler.phtml');
                    } else {
                        $alquiler_canceladas_html .= $this->view->render('cuenta/lista_row_alquiler.phtml');
                    }
                    break;
                case 'viaje':
                    if ($c->getEstado() == 'pendiente') {
                        $viaje_pendientes_html .= $this->view->render('cuenta/lista_row_viaje.phtml');
                    } else {
                        $viaje_canceladas_html .= $this->view->render('cuenta/lista_row_viaje.phtml');
                    }
                    break;
            }
        }
        $this->view->cuentas_alquiler_pendientes = $alquiler_pendientes_html;
        $this->view->cuentas_alquiler_canceladas = $alquiler_canceladas_html;
        $this->view->cuentas_viaje_pendientes = $viaje_pendientes_html;
        $this->view->cuentas_viaje_canceladas = $viaje_canceladas_html;
    }

    public function camposAction() {
        // action body
    }

}

