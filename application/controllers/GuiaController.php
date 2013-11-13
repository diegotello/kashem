<?php

class GuiaController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    private function _exists($params, $field) {
        return isset($params[$field]) && $params[$field] != "" && $params[$field] != null;
    }

    private function _setGuiaFromParams($guia, $params) {
        $cm = new Kashem_Model_ClienteMapper();
        $cam = new Kashem_Model_CategoriaMapper();
        $cliente = new Kashem_Model_Cliente();
        $categoria = new Kashem_Model_Categoria();
        $cm->find($params['cliente_id'], $cliente);
        $cam->find($params['categoria_id'], $categoria);
        $guia->setCliente($cliente)
                ->setCategoria($categoria);
    }

    public function indexAction() {
        $mm = new Kashem_Model_GuiaMapper();
        $guias = $mm->fetchAll();
        $html = "";
        foreach ($guias as $m) {
            $this->view->guia = $m;
            $html .= $this->view->render('guia/lista_row.phtml');
        }
        $this->view->guias = $html;
        $this->view->formulario = $this->view->render('guia/formulario.phtml');
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
            $mm = new Kashem_Model_GuiaMapper();
            $result = $mm->findAsArray($id);
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
                //$params = $request->getParams();
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
                $mm = new Kashem_Model_GuiaMapper();
                $guia = new Kashem_Model_Guia();
                $this->_setGuiaFromParams($guia, $params);
                $guia->setId($params['guia_id']);
                $mm->save($guia);
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
                $mm = new Kashem_Model_GuiaMapper();
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
        $this->view->formulario = $this->view->render('guia/formulario.phtml');
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
                $mm = new Kashem_Model_GuiaMapper();
                $guia = new Kashem_Model_Guia();
                $this->_setGuiaFromParams($guia, $params);
                $mm->save($guia);
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

