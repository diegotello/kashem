<?php

class EquipoController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    private function _exists($params, $field) {
        return isset($params[$field]) && $params[$field] != "" && $params[$field] != null;
    }

    private function _setEquipoFromParams($equipo, $params) {
        $equipo->setNombre($params['nombre'])
                ->setDescripcion($params['descripcion'])
                ->setIdentificador($params['identificador']);
    }

    public function indexAction() {
        $cm = new Kashem_Model_EquipoMapper();
        $equipos = $cm->fetchAll();
        $html = "";
        foreach ($equipos as $a) {
            $this->view->equipo = $a;
            $html .= $this->view->render('equipo/lista_row.phtml');
        }
        $this->view->equipos = $html;
        $this->view->formulario = $this->view->render('equipo/formulario.phtml');
    }

    public function nuevoAction() {
        $this->view->formulario = $this->view->render('equipo/formulario.phtml');
    }

    public function formularioAction() {
        // action body
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
                    if ($k == 'nombre') {
                        if (!$this->_exists($params, $k)) {
                            $valid = false;
                            $info .= '<br>El campo ' . str_replace('_', ' ', $k) . ' no puede estar vacio.';
                        }
                    }
                    if ($k == 'identificador') {
                        if (!$this->_exists($params, $k)) {
                            $valid = false;
                            $info .= '<br>El campo ' . str_replace('_', ' ', $k) . ' no puede estar vacio.';
                        } else {
                            //is unique?
                            $em = new Kashem_Model_EquipoMapper();
                            $result = $em->fetchAllBy('identificador', $v);
                            if (!empty($result)) {
                                $valid = false;
                                $info .= '<br>Ya existe un equipo con el identificador ' . $v . '.';
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
                $cm = new Kashem_Model_EquipoMapper();
                $equipo = new Kashem_Model_Equipo();
                $this->_setEquipoFromParams($equipo, $params);
                $cm->save($equipo);
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

    public function infoAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $request = $this->getRequest();
        if ($request->isGet()) {
            $id = $request->getParam('id');
            $cm = new Kashem_Model_EquipoMapper();
            $equipo = $cm->findAsArray($id);
        } else {
            $this->getResponse()->setHttpResponseCode(405);
        }
        $this->_helper->json($equipo);
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
                $cm = new Kashem_Model_EquipoMapper();
                $equipo = new Kashem_Model_Equipo();
                $this->_setEquipoFromParams($equipo, $params);
                $equipo->setId($params['equipo_id']);
                $cm->save($equipo);
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
                $cm = new Kashem_Model_EquipoMapper();
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
            'identificador' => 'identificador',
            'descripcion' => 'descripcion'
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
            $am = new Kashem_Model_EquipoMapper();
            $equipos = $am->fetchAllBy($campo, $valor);
            $html = "";
            foreach ($equipos as $a) {
                $this->view->equipo = $a;
                $html .= $this->view->render('equipo/lista_row.phtml');
            }
        } else {
            $this->getResponse()->setHttpResponseCode(405);
        }
        $this->_helper->json(array('lista' => $html));
    }

}

