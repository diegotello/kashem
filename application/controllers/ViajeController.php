<?php

class ViajeController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    private function _exists($params, $field) {
        return isset($params[$field]) && $params[$field] != "" && $params[$field] != null;
    }

    private function _setViajeFromParams($viaje, $params) {
        $viaje->setNombre($params['nombre'])
                ->setFechaSalida(date('Y-m-d', strtotime($params['fecha_salida'])))
                ->setHoraSalida($params['hora_salida'])
                ->setFechaRegreso(date('Y-m-d', strtotime($params['fecha_regreso'])))
                ->setHoraRegreso($params['hora_regreso']);
    }

    public function indexAction() {
        $pm = new Kashem_Model_ViajeMapper();
        $viajes = $pm->fetchAll();
        $html = "";
        foreach ($viajes as $p) {
            $this->view->viaje = $p;
            $html .= $this->view->render('viaje/lista_row.phtml');
        }
        $this->view->viajes = $html;
        $this->view->formulario = $this->view->render('viaje/formulario.phtml');
    }

    public function nuevoAction() {
        $dm = new Kashem_Model_DestinoMapper();
        $am = new Kashem_Model_ActividadMapper();
        $mm = new Kashem_Model_GuiaMapper();
        $actividades = $am->fetchAll();
        $destinos = $dm->fetchAll();
        $guias = $mm->fetchAll();
        $act_html = "";
        $des_html = "";
        $guias_html = "";
        foreach ($actividades as $a) {
            $this->view->actividad = $a;
            $act_html .= $this->view->render('actividad/lista_viaje_row.phtml');
        }
        foreach ($destinos as $d) {
            $this->view->destino = $d;
            $des_html .= $this->view->render('destino/lista_viaje_row.phtml');
        }
        foreach ($guias as $m) {
            $this->view->guia = $m;
            $guias_html .= $this->view->render('guia/lista_viaje_row.phtml');
        }
        $this->view->guias = $guias_html;
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
                $lengthValidator = new Zend_Validate_StringLength(array('max' => 50));
                $dateValidator = new Zend_Validate_Date(array('format' => 'dd-mm-yyyy'));
                if (!$this->_exists($params, 'nombre')) {
                    $valid = false;
                    $info .= '<br>El campo nombre no puede estar vacio.';
                } else {
                    if (!$lengthValidator->isValid($params['nombre'])) {
                        $valid = false;
                        $info .= '<br>El campo nombre tiene mas de 50 caracteres.';
                    }
                }
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
                if (!$this->_exists($params, 'hora_salida')) {
                    $valid = false;
                    $info .= '<br>El campo hora de salida no puede estar vacio.';
                }
                if (!$this->_exists($params, 'hora_regreso')) {
                    $valid = false;
                    $info .= '<br>El campo hora de regreso no puede estar vacio.';
                }
                if (!$this->_exists($params, 'destino')) {
                    $valid = false;
                    $info .= '<br>Debes seleccionar destinos para el viaje.';
                }
                if (!$this->_exists($params, 'actividad')) {
                    $valid = false;
                    $info .= '<br>Debes seleccionar actividades para el viaje.';
                }
                if (!$this->_exists($params, 'guia')) {
                    $valid = false;
                    $info .= '<br>Debes seleccionar guias para el viaje.';
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
                $pm = new Kashem_Model_ViajeMapper();
                $viaje = new Kashem_Model_Viaje();
                $this->_setViajeFromParams($viaje, $params);
                $pm->create($viaje, $params);
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
            $vam = new Kashem_Model_ViajeActividadMapper();
            $vdm = new Kashem_Model_ViajeDestinoMapper();
            $gvm = new Kashem_Model_GuiaViajeMapper();
            $vm = new Kashem_Model_ViajeMapper();
            $am = new Kashem_Model_ActividadMapper();
            $dm = new Kashem_Model_DestinoMapper();
            $gm = new Kashem_Model_GuiaMapper();
            $actividades = $am->fetchAll();
            $destinos = $dm->fetchAll();
            $guias = $gm->fetchAll();
            $act = array();
            $des = array();
            $guiasa = array();
            $v = new Kashem_Model_Viaje();
            $vm->find($id, $v);
            foreach ($actividades as $a) {
                if ($vam->exists($a, $v)) {
                    $act[] = $a->getId();
                }
            }
            foreach ($destinos as $d) {
                if ($vdm->exists($d, $v)) {
                    $des[] = $d->getId();
                }
            }
            foreach ($guias as $g) {
                if ($gvm->exists($g, $v)) {
                    $guiasa[] = $g->getId();
                }
            }
            $result = array(
                'id' => $v->getId(),
                'nombre' => $v->getNombre(),
                'fecha_salida' => date('d-m-Y', strtotime($v->getFechaSalida())),
                'hora_salida' => $v->getHoraSalida(),
                'fecha_regreso' => date('d-m-Y', strtotime($v->getFechaRegreso())),
                'hora_regreso' => $v->getHoraRegreso(),
                'actividades' => $act,
                'destinos' => $des,
                'guias' => $guiasa
            );
        } else {
            $this->getResponse()->setHttpResponseCode(405);
        }
        $this->_helper->json($result);
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
                $vm = new Kashem_Model_ViajeMapper();
                $viaje = new Kashem_Model_Viaje();
                $this->_setViajeFromParams($viaje, $params);
                $viaje->setId($params['viaje_id']);
                $vm->update($viaje, $params);
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
                $vm = new Kashem_Model_ViajeMapper();
                $id = $request->getParam('id');
                $vm->delete($id);
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
            'fecha_salida' => 'fecha de salida',
            'fecha_regreso' => 'fecha de regreso'
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
            $am = new Kashem_Model_ViajeMapper();
            if ($campo == 'fecha_salida' || $campo == 'fecha_regreso') {
                $valor = date('Y-m-d', strtotime($valor));
            }
            $html = "";
            $vista = 'viaje/lista_row.phtml';
            if (isset($params['origen']) && $params['origen'] == 'inscripcion') {
                $vista = 'viaje/lista_inscripcion_row.phtml';
                $viajes = $am->fetchAllFromTodayBy($campo, $valor);
            } else {
                $viajes = $am->fetchAllBy($campo, $valor);
            }
            foreach ($viajes as $a) {
                $this->view->viaje = $a;
                $html .= $this->view->render($vista);
            }
        } else {
            $this->getResponse()->setHttpResponseCode(405);
        }
        $this->_helper->json(array('lista' => $html));
    }

    public function editarAction() {
        $request = $this->getRequest();
        if ($request->isGet()) {
            $viaje_id = $request->getParam('id');
            $dm = new Kashem_Model_DestinoMapper();
            $am = new Kashem_Model_ActividadMapper();
            $mm = new Kashem_Model_GuiaMapper();
            $actividades = $am->fetchAll();
            $destinos = $dm->fetchAll();
            $guias = $mm->fetchAll();
            $act_html = "";
            $des_html = "";
            $guias_html = "";
            foreach ($actividades as $a) {
                $this->view->actividad = $a;
                $act_html .= $this->view->render('actividad/lista_viaje_row.phtml');
            }
            foreach ($destinos as $d) {
                $this->view->destino = $d;
                $des_html .= $this->view->render('destino/lista_viaje_row.phtml');
            }
            foreach ($guias as $m) {
                $this->view->guia = $m;
                $guias_html .= $this->view->render('guia/lista_viaje_row.phtml');
            }
            $this->view->guias = $guias_html;
            $this->view->destinos = $des_html;
            $this->view->actividades = $act_html;
            $this->view->viajeId = $viaje_id;
            $this->view->formulario = $this->view->render('viaje/formulario.phtml');
        } else {
            $this->getResponse()->setHttpResponseCode(405);
        }
    }

    public function detallesAction() {
        $request = $this->getRequest();
        if ($request->isGet()) {
            $viaje_id = $request->getParam('id');
            $vm = new Kashem_Model_ViajeMapper();
            $vdm = new Kashem_Model_ViajeDestinoMapper();
            $vam = new Kashem_Model_ViajeActividadMapper();
            $gvm = new Kashem_Model_GuiaViajeMapper();
            $cvm = new Kashem_Model_ClienteViajeMapper();
            $alm = new Kashem_Model_ActividadLogroMapper();
            $viaje = new Kashem_Model_Viaje();
            $vm->find($viaje_id, $viaje);
            $vds = $vdm->fetchAllByViaje($viaje);
            $destinos = array();
            foreach ($vds as $vd) {
                $destinos[] = $vd->getDestino();
            }
            $vas = $vam->fetchAllByViaje($viaje);
            $actividades_logros = array();
            foreach ($vas as $va) {
                $als = $alm->fetchAllByActividad($va->getActividad());
                $logros = array();
                foreach ($als as $al) {
                    $logros[] = $al->getLogro()->getNombre();
                }
                $actividades_logros[] = array(
                    'actividad' => $va->getActividad(),
                    'logros' => implode(', ', $logros));
            }
            $gvs = $gvm->fetchAllByViaje($viaje);
            $guias = array();
            foreach ($gvs as $gv) {
                $guias[] = $gv->getGuia();
            }
            $cvs = $cvm->fetchAllByViaje($viaje);
            $clientes = array();
            foreach ($cvs as $cv) {
                $clientes[] = $cv->getCliente();
            }
            $this->view->destinos = $destinos;
            $this->view->actividades_logros = $actividades_logros;
            $this->view->guias = $guias;
            $this->view->clientes = $clientes;
            $this->view->viaje = $viaje;
        } else {
            $this->getResponse()->setHttpResponseCode(405);
        }
    }

    public function terminarAction() {

    }

}

