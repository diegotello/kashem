<?php

class AlquilerController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        $cm = new Kashem_Model_ClienteMapper();
        $clientes = $cm->fetchAll();
        $html = "";
        foreach ($clientes as $c) {
            $this->view->cliente = $c;
            $html .= $this->view->render('cliente/lista_alquiler_row.phtml');
        }
        $this->view->clientes = $html;
        $em = new Kashem_Model_EquipoMapper();
        $equipos = $em->fetchAllDisponibles();
        $ehtml = "";
        foreach ($equipos as $a) {
            $this->view->equipo = $a;
            $ehtml .= $this->view->render('equipo/lista_alquiler_row.phtml');
        }
        $this->view->equipos = $ehtml;
    }

}

