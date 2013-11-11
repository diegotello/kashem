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
        $info = "<strong>Hemos encontrado algunos problemas con los datos introducidos:";
        if ($request->isGet()) {
            try {
                $params = $request->getParams();
                $lengthValidator = new Zend_Validate_StringLength(array('max' => 50));
                $emailValidator = new Zend_Validate_EmailAddress();
                $dateValidator = new Zend_Validate_Date(array('format' => 'dd-mm-yyyy'));
                foreach ($params as $k => $v) {
                    //check required fields
                    if ($k == 'pais' || $k == 'departamento' || $k == 'municipio' || $k == 'primer_nombre' || $k == 'primer_apellido') {
                        if (!$this->_exists($params, $k)) {
                            $valid = false;
                            $info .= '<br>El campo ' . str_replace('_', ' ', $k) . ' no puede estar vacio.';
                        }
                    }
                    //check date
                    if ($k == 'fecha_nacimiento') {
                        if ($this->_exists($params, 'fecha_nacimiento')) {
                            if (!$dateValidator->isValid($params['fecha_nacimiento'])) {
                                $valid = false;
                                $info .= '<br>La fecha de nacimiento es invalida.';
                            }
                        }
                    }
                    //check email
                    if ($k == 'email') {
                        if ($this->_exists($params, 'email')) {
                            if (!$emailValidator->isValid($params['email'])) {
                                $valid = false;
                                $info .= '<br>El email es invalido.';
                            }
                        }
                    }
                    //check string length
                    if ($k !== 'observaciones_medicas' && $k !== 'observaciones_generales') {
                        if (!$lengthValidator->isValid($v)) {
                            $valid = false;
                            $info .= '<br>El campo ' . str_replace('_', ' ', $k) . ' tiene mas de 50 caracteres.';
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

    public function guardarAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $request = $this->getRequest();
        $ok = false;
        $info = "";
        if ($request->isPost()) {
            try {
                $params = $request->getParams();
                $pm = new Kashem_Model_PaisMapper();
                $dm = new Kashem_Model_DepartamentoMapper();
                $mm = new Kashem_Model_MunicipioMapper();
                $cm = new Kashem_Model_ClienteMapper();
                $pais = new Kashem_Model_Pais();
                $departamento = new Kashem_Model_Departamento();
                $municipio = new Kashem_Model_Municipio();
                $pm->find($params['pais'], $pais);
                $dm->find($params['departamento'], $departamento);
                $mm->find($params['municipio'], $municipio);
                $cliente = new Kashem_Model_Cliente();
                $cliente->setContactoEmergencia($params['contacto_emergencia'])
                        ->setCorreoElectronico($params['email'])
                        ->setDepartamento($departamento)
                        ->setDireccion($params['direccion'])
                        ->setDpi($params['dpi'])
                        ->setFechaNacimiento(date('Y-m-d', strtotime($params['fecha_nacimiento'])))
                        ->setGenero($params['genero'])
                        ->setMunicipio($municipio)
                        ->setObservacionGeneral($params['observaciones_generales'])
                        ->setObservacionMedica($params['observaciones_medicas'])
                        ->setPais($pais)
                        ->setPrimerApellido($params['primer_apellido'])
                        ->setPrimerNombre($params['primer_nombre'])
                        ->setSegundoApellido($params['segundo_apellido'])
                        ->setSegundoNombre($params['segundo_nombre'])
                        ->setTelefonoEmergencia($params['telefono_emergencia'])
                        ->setTelefono($params['telefono'])
                        ->setUsuarioFacebook($params['usuario_facebook']);
                $cm->save($cliente);
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

