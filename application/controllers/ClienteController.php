<?php

class ClienteController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    private function _exists($params, $field) {
        return isset($params[$field]) && $params[$field] != "" && $params[$field] != null;
    }

    private function _setClienteFromParams($cliente, $params) {
        $pm = new Kashem_Model_PaisMapper();
        $dm = new Kashem_Model_DepartamentoMapper();
        $mm = new Kashem_Model_MunicipioMapper();
        $pais = new Kashem_Model_Pais();
        $departamento = new Kashem_Model_Departamento();
        $municipio = new Kashem_Model_Municipio();
        $pm->find($params['pais_id'], $pais);
        $dm->find($params['departamento_id'], $departamento);
        $mm->find($params['municipio_id'], $municipio);
        $cliente->setContactoEmergencia($params['contacto_emergencia'])
                ->setCorreoElectronico($params['correo_electronico'])
                ->setDepartamento($departamento)
                ->setDireccion($params['direccion'])
                ->setDpi($params['dpi'])
                ->setFechaNacimiento(date('Y-m-d', strtotime($params['fecha_nacimiento'])))
                ->setGenero($params['genero'])
                ->setMunicipio($municipio)
                ->setObservacionGeneral($params['observacion_general'])
                ->setObservacionMedica($params['observacion_medica'])
                ->setPais($pais)
                ->setPrimerApellido($params['primer_apellido'])
                ->setPrimerNombre($params['primer_nombre'])
                ->setSegundoApellido($params['segundo_apellido'])
                ->setSegundoNombre($params['segundo_nombre'])
                ->setTelefonoEmergencia($params['telefono_emergencia'])
                ->setTelefono($params['telefono'])
                ->setUsuarioFacebook($params['usuario_facebook']);
    }

    public function indexAction() {
        $cm = new Kashem_Model_ClienteMapper();
        $clientes = $cm->fetchAll();
        $html = "";
        foreach ($clientes as $c) {
            $this->view->cliente = $c;
            $html .= $this->view->render('cliente/lista_row.phtml');
        }
        $this->view->clientes = $html;
        $this->view->formulario = $this->view->render('cliente/formulario.phtml');
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
                    if ($k == 'pais_id' || $k == 'departamento_id' || $k == 'municipio_id' || $k == 'primer_nombre' || $k == 'primer_apellido') {
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
                    if ($k == 'correo_electronico') {
                        if ($this->_exists($params, 'correo_electronico')) {
                            if (!$emailValidator->isValid($params['correo_electronico'])) {
                                $valid = false;
                                $info .= '<br>El email es invalido.';
                            }
                        }
                    }
                    //check string length
                    if ($k !== 'observacion_medica' && $k !== 'observacion_general') {
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
                $cm = new Kashem_Model_ClienteMapper();
                $cliente = new Kashem_Model_Cliente();
                $this->_setClienteFromParams($cliente, $params);
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

    public function nuevoAction() {
        $this->view->formulario = $this->view->render('cliente/formulario.phtml');
    }

    public function infoAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $request = $this->getRequest();
        if ($request->isGet()) {
            $id = $request->getParam('id');
            $cm = new Kashem_Model_ClienteMapper();
            $cliente = $cm->findAsArray($id);
            $cliente['fecha_nacimiento'] = date('d-m-Y', strtotime($cliente['fecha_nacimiento']));
        } else {
            $this->getResponse()->setHttpResponseCode(405);
        }
        $this->_helper->json($cliente);
    }

    public function actualizarAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $request = $this->getRequest();
        $ok = false;
        $info = "";
        if ($request->isPost()) {
            try {
                $params = $request->getParams();
                $cm = new Kashem_Model_ClienteMapper();
                $cliente = new Kashem_Model_Cliente();
                $this->_setClienteFromParams($cliente, $params);
                $cliente->setId($params['cliente_id']);
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

    public function borrarAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $request = $this->getRequest();
        $ok = false;
        $info = "";
        if ($request->isPost()) {
            try {
                $cm = new Kashem_Model_ClienteMapper();
                $id = $request->getParam('id');
                $cm->delete($id);
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

    public function camposAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->view->campos = array(
            'primer_nombre' => 'nombre',
            'primer_apellido' => 'apellido'
        );
        $this->_helper->json(array('lista' => $this->view->render('partials/opciones.phtml')));
    }

    public function busquedaAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $request = $this->getRequest();
        if ($request->isGet()) {
            $campo = $request->getParam('campo_busqueda');
            $valor = $request->getParam('valor_busqueda');
            $am = new Kashem_Model_ClienteMapper();
            $actividades = $am->fetchAllBy($campo, $valor);
            $html = "";
            foreach ($actividades as $a) {
                $this->view->cliente = $a;
                $html .= $this->view->render('cliente/lista_row.phtml');
            }
        } else {
            $this->getResponse()->setHttpResponseCode(405);
        }
        $this->_helper->json(array('lista' => $html));
    }

}

