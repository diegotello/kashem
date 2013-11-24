<?php

class AlquilerController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    private function _exists($params, $field) {
        return isset($params[$field]) && $params[$field] != "" && $params[$field] != null;
    }

    public function indexAction() {
        $request = $this->getRequest();
        $cm = new Kashem_Model_ClienteMapper();
        $html = "";
        if ($request->isGet()) {
            $params = $request->getParams();
            if (isset($params['cliente_id']) && isset($params['origin'])) {
                if ($params['origin'] == 'inscripcion') {
                    $c = new Kashem_Model_Cliente();
                    $cm->find($params['cliente_id'], $c);
                    $this->view->cliente = $c;
                    $html .= $this->view->render('cliente/lista_alquiler_row.phtml');
                }
            } else {
                $clientes = $cm->fetchAll();
                foreach ($clientes as $c) {
                    $this->view->cliente = $c;
                    $html .= $this->view->render('cliente/lista_alquiler_row.phtml');
                }
            }
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

    public function guardarAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $request = $this->getRequest();
        $ok = false;
        $info = "";
        if ($request->isPost()) {
            try {
                $params = $request->getParams();
                $am = new Kashem_Model_AlquilerMapper();
                $am->rent($params);
                $ok = true;
            } catch (Exception $e) {
                $ok = false;
                $info = $e->getMessage();
            }
        } else {
            $this->getResponse()->setHttpResponseCode(405);
        }
        $this->_helper->json(array('ok' => $ok, 'info' => $info));
    }

    public function validarformularioAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $request = $this->getRequest();
        $valid = true;
        $info = "<strong>Hemos encontrado algunos problemas con los datos introducidos:";
        if ($request->isGet()) {
            try {
                $params = $request->getParams();
                $dateValidator = new Zend_Validate_Date(array('format' => 'dd-mm-yyyy'));
                $currencyValidator = new Zend_Validate_Regex(array('pattern' => '/^\$?[0-9]+(,[0-9]{3})*(.[0-9]{2})?$/'));
                foreach ($params as $k => $v) {
                    //check required fields
                    if ($k == 'cliente_id') {
                        if (!$this->_exists($params, $k)) {
                            $valid = false;
                            $info .= '<br>Debes seleccionar un cliente.';
                        }
                    }
                    if ($k == 'equipo') {
                        if (!$this->_exists($params, $k)) {
                            $valid = false;
                            $info .= '<br>Debes seleccionar equipo para alquilar.';
                        } else { //check if all equipos are available
                            $em = new Kashem_Model_EquipoMapper();
                            $equipo = new Kashem_Model_Equipo();
                            foreach ($v as $id) {
                                $em->find($id, $equipo);
                                if ($equipo->getDisponible() != 1) {
                                    $valid = false;
                                    $info .= '<br>El equipo ' . $equipo->getNombre() . ' ' . $equipo->getIdentificador() . ' ya no se encuentra disponible.';
                                }
                            }
                        }
                    }
                    //check date
                    if ($k == 'renta' || $k == 'devolucion') {
                        if ($this->_exists($params, $k)) {
                            if (!$dateValidator->isValid($v)) {
                                $valid = false;
                                $info .= '<br>La fecha de ' . $k . ' es invalida.';
                            }
                        } else {
                            $valid = false;
                            $info .= '<br>Debes seleccionar una fecha de ' . $k . '.';
                        }
                    }
                    //check costo and deposito
                    if ($k == 'costo' || $k == 'deposito') {
                        if ($this->_exists($params, $k)) {
                            if (!$currencyValidator->isValid($v)) {
                                $valid = false;
                                $info .= '<br>El valor ingresado para ' . $k . ' es invalido.';
                            }
                        } else {
                            $valid = false;
                            $info .= '<br>Debes ingresar un valor para el ' . $k . '.';
                        }
                    }
                }
            } catch (Exception $e) {
                $valid = false;
                $info = $e->getMessage();
            }
        } else {
            $this->getResponse()->setHttpResponseCode(405);
        }
        $info .= '</strong>';
        $this->_helper->json(array('valid' => $valid, 'info' => $info));
    }

}

