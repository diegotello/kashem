<?php

class UsuarioController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    private function _exists($params, $field) {
        return isset($params[$field]) && $params[$field] != "" && $params[$field] != null;
    }

    private function _setUsuarioFromParams($usuario, $params) {
        $pm = new Kashem_Model_RolMapper();
        $rol = new Kashem_Model_Rol();
        $pm->find($params['rol_id'], $rol);
        $usuario->setNombre($params['nombre'])
                ->setPassword($params['password'])
                ->setRol($rol);
    }

    public function indexAction() {
        $dm = new Kashem_Model_UsuarioMapper();
        $usuarios = $dm->fetchAll();
        $html = "";
        foreach ($usuarios as $d) {
            $this->view->usuario = $d;
            $html .= $this->view->render('usuario/lista_row.phtml');
        }
        $this->view->usuarios = $html;
        $this->view->formulario = $this->view->render('usuario/formulario.phtml');
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
            $dm = new Kashem_Model_UsuarioMapper();
            $usuario = $dm->findAsArray($id);
        } else {
            $this->getResponse()->setHttpResponseCode(405);
        }
        $this->_helper->json($usuario);
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
                if (!$this->_exists($params, 'rol_id')) {
                    $valid = false;
                    $info .= '<br>El campo rol no puede estar vacio.';
                }
                if (!$this->_exists($params, 'password')) {
                    $valid = false;
                    $info .= '<br>El campo password no puede estar vacio.';
                }
                if (!$lengthValidator->isValid($params['nombre'])) {
                    $valid = false;
                    $info .= '<br>El campo nombre tiene mas de 50 caracteres.';
                }
                if (!$lengthValidator->isValid($params['password'])) {
                    $valid = false;
                    $info .= '<br>El campo password tiene mas de 50 caracteres.';
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
                $dm = new Kashem_Model_UsuarioMapper();
                $usuario = new Kashem_Model_Usuario();
                $this->_setUsuarioFromParams($usuario, $params);
                $usuario->setId($params['usuario_id']);
                $dm->save($usuario);
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
                $dm = new Kashem_Model_UsuarioMapper();
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
        $this->view->formulario = $this->view->render('usuario/formulario.phtml');
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
                $dm = new Kashem_Model_UsuarioMapper();
                $usuario = new Kashem_Model_Usuario();
                $this->_setUsuarioFromParams($usuario, $params);
                $dm->save($usuario);
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

