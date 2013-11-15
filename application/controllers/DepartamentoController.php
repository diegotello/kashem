<?php

class DepartamentoController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    private function _exists($params, $field) {
        return isset($params[$field]) && $params[$field] != "" && $params[$field] != null;
    }

    private function _setDepartamentoFromParams($departamento, $params) {
        $pm = new Kashem_Model_PaisMapper();
        $pais = new Kashem_Model_Pais();
        $pm->find($params['pais_id'], $pais);
        $departamento->setNombre($params['nombre'])
                ->setPais($pais);
    }

    public function indexAction() {
        $dm = new Kashem_Model_DepartamentoMapper();
        $departamentos = $dm->fetchAll();
        $html = "";
        foreach ($departamentos as $d) {
            $this->view->departamento = $d;
            $html .= $this->view->render('departamento/lista_row.phtml');
        }
        $this->view->departamentos = $html;
        $this->view->formulario = $this->view->render('departamento/formulario.phtml');
    }

    public function listaAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $request = $this->getRequest();
        if ($request->isGet()) {
            $pm = new Kashem_Model_PaisMapper();
            $dm = new Kashem_Model_DepartamentoMapper();
            $pais = new Kashem_Model_Pais();
            $pm->find($request->getParam('pais_id'), $pais);
            $this->view->departamentos = $dm->fetchAllByPais($pais);
            $this->_helper->json(array('lista' => $this->view->render('departamento/lista.phtml')));
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
            $dm = new Kashem_Model_DepartamentoMapper();
            $departamento = $dm->findAsArray($id);
        } else {
            $this->getResponse()->setHttpResponseCode(405);
        }
        $this->_helper->json($departamento);
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
                $dm = new Kashem_Model_DepartamentoMapper();
                $departamento = new Kashem_Model_Departamento();
                $this->_setDepartamentoFromParams($departamento, $params);
                $departamento->setId($params['departamento_id']);
                $dm->save($departamento);
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
                $dm = new Kashem_Model_DepartamentoMapper();
                $id = $request->getParam('id');
                $dm->delete($id);
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
        $this->view->formulario = $this->view->render('departamento/formulario.phtml');
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
                $dm = new Kashem_Model_DepartamentoMapper();
                $departamento = new Kashem_Model_Departamento();
                $this->_setDepartamentoFromParams($departamento, $params);
                $dm->save($departamento);
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
            'nombre' => 'nombre'
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
            $am = new Kashem_Model_DepartamentoMapper();
            $departamentos = $am->fetchAllBy($campo, $valor);
            $html = "";
            foreach ($departamentos as $a) {
                $this->view->departamento = $a;
                $html .= $this->view->render('departamento/lista_row.phtml');
            }
        } else {
            $this->getResponse()->setHttpResponseCode(405);
        }
        $this->_helper->json(array('lista' => $html));
    }

}

