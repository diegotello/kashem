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

    public function nuevaAction() {
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

}

