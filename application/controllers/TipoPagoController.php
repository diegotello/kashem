<?php

class TipoPagoController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    private function _exists($params, $field) {
        return isset($params[$field]) && $params[$field] != "" && $params[$field] != null;
    }

    private function _setTipoPagoFromParams($tipo_pago, $params) {
        $tipo_pago->setNombre($params['nombre'])
                ->setDescripcion($params['descripcion']);
    }

    public function indexAction() {
        $am = new Kashem_Model_TipoPagoMapper();
        $tipos_pago = $am->fetchAll();
        $html = "";
        foreach ($tipos_pago as $a) {
            $this->view->tipo_pago = $a;
            $html .= $this->view->render('tipo-pago/lista_row.phtml');
        }
        $this->view->tipos_pago = $html;
        $this->view->formulario = $this->view->render('tipo-pago/formulario.phtml');
    }

    public function nuevoAction() {
        $this->view->formulario = $this->view->render('tipo-pago/formulario.phtml');
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
                        } else {
                            //is unique?
                            if (!$this->_exists($params, 'tipo-pago_id')) {
                                $em = new Kashem_Model_TipoPagoMapper();
                                $result = $em->fetchAllBy('nombre', $v);
                                if (!empty($result)) {
                                    if ($result[0]->getId() != $params['tipo-pago_id']) {
                                        $valid = false;
                                        $info .= '<br>Ya existe un tipo de pago con el nombre ' . $v . '.';
                                    }
                                }
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
                $am = new Kashem_Model_TipoPagoMapper();
                $tipo_pago = new Kashem_Model_TipoPago();
                $this->_setTipoPagoFromParams($tipo_pago, $params);
                $am->save($tipo_pago);
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
            $am = new Kashem_Model_TipoPagoMapper();
            $tipo_pago = $am->findAsArray($id);
        } else {
            $this->getResponse()->setHttpResponseCode(405);
        }
        $this->_helper->json($tipo_pago);
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
                $am = new Kashem_Model_TipoPagoMapper();
                $tipo_pago = new Kashem_Model_TipoPago();
                $this->_setTipoPagoFromParams($tipo_pago, $params);
                $tipo_pago->setId($params['tipo-pago_id']);
                $am->save($tipo_pago);
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
                $am = new Kashem_Model_TipoPagoMapper();
                $id = $request->getParam('id');
                $am->delete($id);
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
            $campo = $request->getParam('campo_busqueda');
            $valor = $request->getParam('valor_busqueda');
            $am = new Kashem_Model_TipoPagoMapper();
            $tipos_pago = $am->fetchAllBy($campo, $valor);
            $html = "";
            foreach ($tipos_pago as $a) {
                $this->view->tipo_pago = $a;
                $html .= $this->view->render('tipo-pago/lista_row.phtml');
            }
        } else {
            $this->getResponse()->setHttpResponseCode(405);
        }
        $this->_helper->json(array('lista' => $html));
    }

}

