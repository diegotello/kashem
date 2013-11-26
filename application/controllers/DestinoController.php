<?php

class DestinoController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    private function _exists($params, $field) {
        return isset($params[$field]) && $params[$field] != "" && $params[$field] != null;
    }

    private function _setDestinoFromParams($destino, $params) {
        $pm = new Kashem_Model_PaisMapper();
        $dm = new Kashem_Model_DepartamentoMapper();
        $mm = new Kashem_Model_MunicipioMapper();
        $pais = new Kashem_Model_Pais();
        $departamento = new Kashem_Model_Departamento();
        $municipio = new Kashem_Model_Municipio();
        $pm->find($params['pais_id'], $pais);
        $dm->find($params['departamento_id'], $departamento);
        $mm->find($params['municipio_id'], $municipio);
        $destino->setDepartamento($departamento)
                ->setMunicipio($municipio)
                ->setPais($pais)
                ->setNombre($params['nombre'])
                ->setDescripcion($params['descripcion']);
    }

    public function indexAction() {
        $cm = new Kashem_Model_DestinoMapper();
        $destinos = $cm->fetchAll();
        $html = "";
        foreach ($destinos as $c) {
            $this->view->destino = $c;
            $html .= $this->view->render('destino/lista_row.phtml');
        }
        $this->view->destinos = $html;
        $this->view->formulario = $this->view->render('destino/formulario.phtml');
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
                foreach ($params as $k => $v) {
                    //check required fields
                    if ($k == 'pais_id' || $k == 'departamento_id' || $k == 'municipio_id') {
                        if (!$this->_exists($params, $k)) {
                            $valid = false;
                            $info .= '<br>El campo ' . str_replace('_', ' ', $k) . ' no puede estar vacio.';
                        }
                    }
                    if ($k == 'nombre') {
                        if (!$this->_exists($params, $k)) {
                            $valid = false;
                            $info .= '<br>El campo ' . str_replace('_', ' ', $k) . ' no puede estar vacio.';
                        } else {
                            //is unique?
                            $em = new Kashem_Model_DestinoMapper();
                            $result = $em->fetchAllBy('nombre', $v);
                            if (!empty($result)) {
                                $valid = false;
                                $info .= '<br>Ya existe un destino con el nombre ' . $v . '.';
                            }
                        }
                    }
                    //check string length
                    if ($k !== 'descripcion') {
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
                $cm = new Kashem_Model_DestinoMapper();
                $destino = new Kashem_Model_Destino();
                $this->_setDestinoFromParams($destino, $params);
                $cm->save($destino);
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
        $this->view->formulario = $this->view->render('destino/formulario.phtml');
    }

    public function infoAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $request = $this->getRequest();
        if ($request->isGet()) {
            $id = $request->getParam('id');
            $cm = new Kashem_Model_DestinoMapper();
            $destino = $cm->findAsArray($id);
        } else {
            $this->getResponse()->setHttpResponseCode(405);
        }
        $this->_helper->json($destino);
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
                $cm = new Kashem_Model_DestinoMapper();
                $destino = new Kashem_Model_Destino();
                $this->_setDestinoFromParams($destino, $params);
                $destino->setId($params['destino_id']);
                $cm->save($destino);
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
                $cm = new Kashem_Model_DestinoMapper();
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
            'nombre' => 'nombre',
            'descripcion' => 'descripcion'
        );
        $this->_helper->json(array('lista' => $this->view->render('partials/opciones.phtml')));
    }

    public function busquedaAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $request = $this->getRequest();
        if ($request->isGet()) {
            $params = $request->getParams();
            $campo = $params['campo_busqueda'];
            $valor = $params['valor_busqueda'];
            $am = new Kashem_Model_DestinoMapper();
            $destinos = $am->fetchAllBy($campo, $valor);
            $html = "";
            $vista = 'destino/lista_row.phtml';
            if (isset($params['origen']) && $params['origen'] == 'viaje') {
                $vista = 'destino/lista_viaje_row.phtml';
            }
            foreach ($destinos as $a) {
                $this->view->destino = $a;
                $html .= $this->view->render($vista);
            }
        } else {
            $this->getResponse()->setHttpResponseCode(405);
        }
        $this->_helper->json(array('lista' => $html));
    }

}

