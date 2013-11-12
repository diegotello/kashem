<?php

class LogroController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    private function _exists($params, $field) {
        return isset($params[$field]) && $params[$field] != "" && $params[$field] != null;
    }

    private function _setLogroFromParams($logro, $params) {
        $logro->setNombre($params['nombre']);
    }

    public function indexAction() {
        $pm = new Kashem_Model_LogroMapper();
        $logros = $pm->fetchAll();
        $html = "";
        foreach ($logros as $p) {
            $this->view->logro = $p;
            $html .= $this->view->render('logro/lista_row.phtml');
        }
        $this->view->logros = $html;
        $this->view->formulario = $this->view->render('logro/formulario.phtml');
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
            $pm = new Kashem_Model_LogroMapper();
            $logro = $pm->findAsArray($id);
        } else {
            $this->getResponse()->setHttpResponseCode(405);
        }
        $this->_helper->json($logro);
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
                $nombre = $params['nombre'];
                if (!$this->_exists($params, 'nombre')) {
                    $valid = false;
                    $info .= '<br>El campo nombre no puede estar vacio.';
                }
                if (!$lengthValidator->isValid($nombre)) {
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
                $pm = new Kashem_Model_LogroMapper();
                $logro = new Kashem_Model_Logro();
                $this->_setLogroFromParams($logro, $params);
                $logro->setId($params['logro_id']);
                $pm->save($logro);
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
                $pm = new Kashem_Model_LogroMapper();
                $id = $request->getParam('id');
                $pm->delete($id);
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
        $this->view->formulario = $this->view->render('logro/formulario.phtml');
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
                $pm = new Kashem_Model_LogroMapper();
                $logro = new Kashem_Model_Logro();
                $this->_setLogroFromParams($logro, $params);
                $pm->save($logro);
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
