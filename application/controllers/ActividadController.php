<?php

class ActividadController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    private function _exists($params, $field) {
        return isset($params[$field]) && $params[$field] != "" && $params[$field] != null;
    }

    private function _setActividadFromParams($actividad, $params) {
        $actividad->setNombre($params['nombre'])
                ->setDescripcion($params['descripcion']);
    }

    public function indexAction() {
        $am = new Kashem_Model_ActividadMapper();
        $actividades = $am->fetchAll();
        $html = "";
        foreach ($actividades as $a) {
            $this->view->actividad = $a;
            $html .= $this->view->render('actividad/lista_row.phtml');
        }
        $this->view->actividades = $html;
        $this->view->formulario = $this->view->render('actividad/formulario.phtml');
    }

    public function nuevoAction() {
        $this->view->formulario = $this->view->render('actividad/formulario.phtml');
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
                            if (!$this->_exists($params, 'actividad_id')) {
                                $em = new Kashem_Model_ActividadMapper();
                                $result = $em->fetchAllBy('nombre', $v);
                                if (!empty($result)) {
                                    $valid = false;
                                    $info .= '<br>Ya existe una actividad con el nombre ' . $v . '.';
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
                $am = new Kashem_Model_ActividadMapper();
                $actividad = new Kashem_Model_Actividad();
                $this->_setActividadFromParams($actividad, $params);
                $am->save($actividad);
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
            $am = new Kashem_Model_ActividadMapper();
            $actividad = $am->findAsArray($id);
        } else {
            $this->getResponse()->setHttpResponseCode(405);
        }
        $this->_helper->json($actividad);
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
                $am = new Kashem_Model_ActividadMapper();
                $actividad = new Kashem_Model_Actividad();
                $this->_setActividadFromParams($actividad, $params);
                $actividad->setId($params['actividad_id']);
                $am->save($actividad);
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
                $am = new Kashem_Model_ActividadMapper();
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
            $params = $request->getParams();
            $campo = $params['campo_busqueda'];
            $valor = $params['valor_busqueda'];
            $am = new Kashem_Model_ActividadMapper();
            $actividades = $am->fetchAllBy($campo, $valor);
            $html = "";
            $vista = 'actividad/lista_row.phtml';
            if (isset($params['origen']) && $params['origen'] == 'viaje') {
                $vista = 'actividad/lista_viaje_row.phtml';
            }
            foreach ($actividades as $a) {
                $this->view->actividad = $a;
                $html .= $this->view->render($vista);
            }
        } else {
            $this->getResponse()->setHttpResponseCode(405);
        }
        $this->_helper->json(array('lista' => $html));
    }

}

