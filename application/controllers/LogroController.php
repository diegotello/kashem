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
            $alm = new Kashem_Model_ActividadLogroMapper();
            $pm = new Kashem_Model_LogroMapper();
            $logro = $pm->findAsArray($id);
            $am = new Kashem_Model_ActividadMapper();
            $actividades = $am->fetchAll();
            $act_html = "";
            $l = new Kashem_Model_Logro();
            $pm->find($id, $l);
            $campos = array();
            foreach ($actividades as $a) {
                $this->view->actividad = $a;
                if ($alm->exists($a, $l)) {
                    $actividad = $a->getId();
                }
                $campos[$a->getId()] = $a->getNombre();
            }
            $this->view->campos = $campos;
            $act_html .= $this->view->render('partials/opciones.phtml');
            $result['id'] = $logro['id'];
            $result['nombre'] = $logro['nombre'];
            $result['actividades'] = $act_html;
            $result['actividad'] = $actividad;
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
                $lengthValidator = new Zend_Validate_StringLength(array('max' => 50));
                $nombre = $params['nombre'];
                if (!$this->_exists($params, 'nombre')) {
                    $valid = false;
                    $info .= '<br>El campo nombre no puede estar vacio.';
                } else {
//is unique?
                    if (!$this->_exists($params, 'logro_id')) {
                        $em = new Kashem_Model_LogroMapper();
                        $result = $em->fetchAllBy('nombre', $nombre);
                        if (!empty($result)) {
                            $valid = false;
                            $info .= '<br>Ya existe un logro con el nombre ' . $nombre . '.';
                        }
                    }
                }
                if (!$lengthValidator->isValid($nombre)) {
                    $valid = false;
                    $info .= '<br>El campo nombre tiene mas de 50 caracteres.';
                }
                if (!$this->_exists($params, 'actividad_id')) {
                    $valid = false;
                    $info .= '<br>Debes seleccionar una actividad.';
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
                $alm = new Kashem_Model_ActividadLogroMapper();
                $alm->deleteByLogro($logro);
                $am = new Kashem_Model_ActividadMapper();
                $actividad = new Kashem_Model_Actividad();
                $actividadLogro = new Kashem_Model_ActividadLogro();
                $am->find($params['actividad_id'], $actividad);
                $actividadLogro->setActividad($actividad);
                $actividadLogro->setLogro($logro);
                $alm->save($actividadLogro);
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
        $am = new Kashem_Model_ActividadMapper();
        $actividades = $am->fetchAll();
        $act_html = "";
        $campos = array();
        foreach ($actividades as $a) {
            $campos[$a->getId()] = $a->getNombre();
        }
        $this->view->campos = $campos;
        $act_html .= $this->view->render('partials/opciones.phtml');
        $this->view->actividades = $act_html;
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
                $am = new Kashem_Model_ActividadMapper();
                $alm = new Kashem_Model_ActividadLogroMapper();
                $actividad = new Kashem_Model_Actividad();
                $actividadLogro = new Kashem_Model_ActividadLogro();
                $am->find($params['actividad_id'], $actividad);
                $actividadLogro->setActividad($actividad);
                $actividadLogro->setLogro($logro);
                $alm->save($actividadLogro);
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
            $am = new Kashem_Model_LogroMapper();
            $logros = $am->fetchAllBy($campo, $valor);
            $html = "";
            foreach ($logros as $a) {
                $this->view->logro = $a;
                $html .= $this->view->render('logro/lista_row.phtml');
            }
        } else {
            $this->getResponse()->setHttpResponseCode(405);
        }
        $this->_helper->json(array('lista' => $html));
    }

}

