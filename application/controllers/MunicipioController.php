<?php

class MunicipioController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    private function _exists($params, $field) {
        return isset($params[$field]) && $params[$field] != "" && $params[$field] != null;
    }

    private function _setMunicipioFromParams($municipio, $params) {
        $dm = new Kashem_Model_DepartamentoMapper();
        $departamento = new Kashem_Model_Departamento();
        $dm->find($params['departamento_id'], $departamento);
        $municipio->setNombre($params['nombre'])
                ->setDepartamento($departamento);
    }

    public function indexAction() {
        $mm = new Kashem_Model_MunicipioMapper();
        $municipios = $mm->fetchAll();
        $html = "";
        foreach ($municipios as $m) {
            $this->view->municipio = $m;
            $html .= $this->view->render('municipio/lista_row.phtml');
        }
        $this->view->municipios = $html;
        $this->view->formulario = $this->view->render('municipio/formulario.phtml');
    }

    public function listaAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $request = $this->getRequest();
        if ($request->isGet()) {
            $dm = new Kashem_Model_DepartamentoMapper();
            $mm = new Kashem_Model_MunicipioMapper();
            $departamento = new Kashem_Model_Departamento();
            $dm->find($request->getParam('departamento_id'), $departamento);
            $this->view->municipios = $mm->fetchAllByDepartamento($departamento);
            $this->_helper->json(array('lista' => $this->view->render('municipio/lista.phtml')));
        }
    }

    public function formularioAction() {
        // action body
    }

    public function infoAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $request = $this->getRequest();
        if ($request->isGet()) {
            $id = $request->getParam('id');
            $mm = new Kashem_Model_MunicipioMapper();
            $om = new Kashem_Model_Municipio();
            $mm->find($id, $om);
            $result['nombre'] = $om->getNombre();
            $result['departamento_id'] = $om->getDepartamento()->getId();
            $result['pais_id'] = $om->getDepartamento()->getPais()->getId();
            $result['id'] = $om->getId();
        } else {
            $this->getResponse()->setHttpResponseCode(405);
        }
        $this->_helper->json($result);
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
                if (!$this->_exists($params, 'nombre')) {
                    $valid = false;
                    $info .= '<br>El campo nombre no puede estar vacio.';
                }
                if (!$this->_exists($params, 'pais_id')) {
                    $valid = false;
                    $info .= '<br>El campo pais no puede estar vacio.';
                }
                if (!$this->_exists($params, 'departamento_id')) {
                    $valid = false;
                    $info .= '<br>El campo departamento no puede estar vacio.';
                }
                if (!$lengthValidator->isValid($params['nombre'])) {
                    $valid = false;
                    $info .= '<br>El campo nombre tiene mas de 50 caracteres.';
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

    public function actualizarAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $request = $this->getRequest();
        $ok = false;
        $info = "";
        if ($request->isPost()) {
            try {
                $params = $request->getParams();
                $mm = new Kashem_Model_MunicipioMapper();
                $municipio = new Kashem_Model_Municipio();
                $this->_setMunicipioFromParams($municipio, $params);
                $municipio->setId($params['municipio_id']);
                $mm->save($municipio);
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
                $mm = new Kashem_Model_MunicipioMapper();
                $id = $request->getParam('id');
                $mm->delete($id);
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
        $this->view->formulario = $this->view->render('municipio/formulario.phtml');
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
                $mm = new Kashem_Model_MunicipioMapper();
                $municipio = new Kashem_Model_Municipio();
                $this->_setMunicipioFromParams($municipio, $params);
                $mm->save($municipio);
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

