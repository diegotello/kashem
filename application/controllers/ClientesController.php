<?php

class ClientesController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    private function _exists($params, $field) {
        return isset($params[$field]) && $params[$field] != "" && $params[$field] != null;
    }

    public function indexAction() {
        // action body
    }

    public function formularioAction() {

    }

    public function validarformularioAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $request = $this->getRequest();
        $valid = true;
        $message = "<strong>Hemos encontrado algunos problemas con los datos introducidos:";
        if ($request->isPost()) {
            $params = $request->getParams();
            $lengthValidator = new Zend_Validate_StringLength(array('max' => 50));
            $emailValidator = new Zend_Validate_EmailAddress();
            $dateValidator = new Zend_Validate_Date(array('format' => 'dd/mm/yyyy'));
            foreach ($params as $k => $v) {
                //check required fields
                if ($k == 'pais' || $k == 'departamento' || $k == 'municipio' || $k == 'primer_nombre' || $k == 'primer_apellido') {
                    if (!$this->_exists($params, $k)) {
                        $valid = false;
                        $message .= '<br>El campo ' . str_replace('_', ' ', $k) . ' no puede estar vacio.';
                    }
                }
                //check date
                if ($k == 'fecha_nacimiento') {
                    if ($this->_exists($params, 'fecha_nacimiento')) {
                        if (!$dateValidator->isValid($params['fecha_nacimiento'])) {
                            $valid = false;
                            $message .= '<br>La fecha de nacimiento es invalida.';
                        }
                    }
                }
                //check email
                if ($k == 'email') {
                    if ($this->_exists($params, 'email')) {
                        if (!$emailValidator->isValid($params['email'])) {
                            $valid = false;
                            $message .= '<br>El email es invalido.';
                        }
                    }
                }
                //check string length
                if ($k !== 'observaciones_medicas' && $k !== 'observaciones_generales') {
                    if (!$lengthValidator->isValid($v)) {
                        $valid = false;
                        $message .= '<br>El campo ' . str_replace('_', ' ', $k) . ' tiene mas de 50 caracteres.';
                    }
                }
            }
            $message .= '</strong>';
            $this->_helper->json(array('valid' => $valid, 'info' => $message));
        }
    }

}

