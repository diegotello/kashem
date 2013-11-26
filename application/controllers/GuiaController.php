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
            $guia = new Kashem_Model_Guia();
            $mm->find($id, $guia);
            $result = array(
                'id' => $guia->getId(),
                'cliente_id' => $guia->getCliente()->getId(),
                'categoria_id' => $guia->getCategoria()->getId(),
                'nombre' => 'Guia #' . $guia->getId() . ', ' . $guia->getCliente()->getPrimerNombre() . ' ' . $guia->getCliente()->getPrimerApellido()
            );
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
                if (!$this->_exists($params, 'cliente_id')) {
                    $valid = false;
                    $info .= '<br>El campo cliente no puede estar vacio.';
                } else {
                    $gm = new Kashem_Model_GuiaMapper();
                    $check = true;
                    if ($params['guia_id'] != '') {
                        $tguia = new Kashem_Model_Guia();
                        $gm->find($params['guia_id'], $tguia);
                        $check = $tguia->getCliente()->getId() != $params['cliente_id'];
                    }
                    if ($check) {
                        $cm = new Kashem_Model_ClienteMapper();
                        $cliente = new Kashem_Model_Cliente();
                        $cm->find($params['cliente_id'], $cliente);
                        $guia = $gm->fetchByCliente($cliente);
                        if ($guia != null) {
                            $valid = false;
                            $info .= '<br>El cliente seleccionado ya es un guia.';
                        }
                    }
                }
                if (!$this->_exists($params, 'categoria_id')) {
                    $valid = false;
                    $info .= '<br>El campo categoria no puede estar vacio.';
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

    public function camposAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->view->campos = array(
            'primer_nombre' => 'nombre',
            'primer_apellido' => 'apellido',
            'nombre' => 'categoria'
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
            $gm = new Kashem_Model_GuiaMapper();
            $vista = 'guia/lista_row.phtml';
            $html = "";
            if (isset($params['origen']) && $params['origen'] == 'viaje') {
                $vista = 'guia/lista_viaje_row.phtml';
            }
            switch ($campo) {
                case 'primer_nombre':
                case 'primer_apellido':
                    $cm = new Kashem_Model_ClienteMapper();
                    $clientes = $cm->fetchAllBy($campo, $valor);
                    foreach ($clientes as $c) {
                        $guia = $gm->fetchByCliente($c);
                        if ($guia != null) {
                            $this->view->guia = $guia;
                            $html .= $this->view->render($vista);
                        }
                    }
                    break;
                case 'nombre':
                    $cm = new Kashem_Model_CategoriaMapper();
                    $categorias = $cm->fetchAllBy('nombre', $valor);
                    foreach ($categorias as $c) {
                        $guias = $gm->fetchAllByCategoria($c);
                        foreach ($guias as $g) {
                            $this->view->guia = $g;
                            $html .= $this->view->render($vista);
                        }
                    }
                    break;
                default:
                    $guias = $gm->fetchAll();
                    foreach ($guias as $g) {
                        $this->view->guia = $g;
                        $html .= $this->view->render($vista);
                    }
                    break;
            }
            $this->_helper->json(array('lista' => $html));
        } else {
            $this->getResponse()->setHttpResponseCode(405);
        }
    }

}

