<?php

class InscripcionController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    private function _exists($params, $field) {
        return isset($params[$field]) && $params[$field] != "" && $params[$field] != null;
    }

    public function indexAction() {
        $vm = new Kashem_Model_ViajeMapper();
        $cm = new Kashem_Model_ClienteMapper();
        $viajes = $vm->fetchAllFromToday();
        $clientes = $cm->fetchAll();
        $vhtml = "";
        $chtml = "";
        foreach ($viajes as $v) {
            $this->view->viaje = $v;
            $vhtml .= $this->view->render('viaje/lista_inscripcion_row.phtml');
        }
        foreach ($clientes as $c) {
            $this->view->cliente = $c;
            $chtml .= $this->view->render('cliente/lista_inscripcion_row.phtml');
        }
        $this->view->viajes = $vhtml;
        $this->view->clientes = $chtml;
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
                $currencyValidator = new Zend_Validate_Regex(array('pattern' => '/^\$?[0-9]+(,[0-9]{3})*(.[0-9]{2})?$/'));
                $checkEnroll = true;
                foreach ($params as $k => $v) {
                    //check required fields
                    if ($k == 'cliente_id') {
                        if (!$this->_exists($params, $k)) {
                            $valid = false;
                            $info .= '<br>Debes seleccionar un cliente.';
                            $checkEnroll = false;
                        }
                    }
                    if ($k == 'viaje_id') {
                        if (!$this->_exists($params, $k)) {
                            $valid = false;
                            $info .= '<br>Debes seleccionar un viaje.';
                            $checkEnroll = false;
                        }
                    }
                    //check costo and deposito
                    if ($k == 'costo') {
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
                //check if client is not already enrolled in this trip
                if ($checkEnroll) {
                    $cm = new Kashem_Model_ClienteMapper();
                    $vm = new Kashem_Model_ViajeMapper();
                    $cvm = new Kashem_Model_ClienteViajeMapper();
                    $cliente = new Kashem_Model_Cliente();
                    $viaje = new Kashem_Model_Viaje();
                    $cm->find($params['cliente_id'], $cliente);
                    $vm->find($params['viaje_id'], $viaje);
                    if ($cvm->exists($cliente, $viaje)) {
                        $valid = false;
                        $info .= '<br> El cliente ' . $cliente->getPrimerNombre() . ' ' . $cliente->getPrimerApellido() . ' quien se identifica con DPI ' . $cliente->getDpi() . ' ya ha sido inscrito en este viaje.';
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

    public function guardarAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $request = $this->getRequest();
        $ok = false;
        $info = "";
        if ($request->isPost()) {
            try {
                $params = $request->getParams();
                $cvm = new Kashem_Model_ClienteViajeMapper();
                $cvm->enroll($params);
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

}

