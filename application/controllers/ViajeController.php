<?php

class ViajeController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        // action body
    }

    public function nuevoAction() {
        $dm = new Kashem_Model_DestinoMapper();
        $am = new Kashem_Model_ActividadMapper();
        $actividades = $am->fetchAll();
        $destinos = $dm->fetchAll();
        $act_html = "";
        $des_html = "";
        foreach ($actividades as $a) {
            $this->view->actividad = $a;
            $act_html .= $this->view->render('actividad/checkboxes.phtml');
        }
        foreach ($destinos as $d) {
            $this->view->destino = $d;
            $des_html .= $this->view->render('destino/checkboxes.phtml');
        }
        $this->view->destinos = $des_html;
        $this->view->actividades = $act_html;
        $this->view->formulario = $this->view->render('viaje/formulario.phtml');
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
                $dateValidator = new Zend_Validate_Date(array('format' => 'dd-mm-yyyy'));
                if (!$this->_exists($params, 'fecha_salida')) {
                    $valid = false;
                    $info .= '<br>El campo fecha de salida no puede estar vacio.';
                } else {
                    if (!$dateValidator->isValid($params['fecha_salida'])) {
                        $valid = false;
                        $info .= '<br>La fecha de salida es invalida.';
                    }
                }
                if (!$this->_exists($params, 'fecha_regreso')) {
                    $valid = false;
                    $info .= '<br>El campo fecha de regreso no puede estar vacio.';
                } else {
                    if (!$dateValidator->isValid($params['fecha_regreso'])) {
                        $valid = false;
                        $info .= '<br>La fecha de regreso es invalida.';
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

}

