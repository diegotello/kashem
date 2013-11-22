<?php

class CuentaController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        $cm = new Kashem_Model_CuentaMapper();
        $cuentas = $cm->fetchAll();
        $pendientes_html = "";
        $canceladas_html = "";
        foreach ($cuentas as $a) {
            $this->view->cuenta = $c;
            $html .= $this->view->render('cuenta/lista_row.phtml');
        }
        $this->view->cuentas = $html;
    }

    public function camposAction() {
        // action body
    }

}

