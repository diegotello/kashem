<?php

class CuentaController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    private function _getLists($cuentas) {
        $alquiler_pendientes_html = "";
        $alquiler_canceladas_html = "";
        $viaje_pendientes_html = "";
        $viaje_canceladas_html = "";
        foreach ($cuentas as $c) {
            $this->view->cuenta = $c;
            switch ($c->tipo) {
                case 'alquiler':
                    if ($c->getEstado() == 'pendiente') {
                        $alquiler_pendientes_html .= $this->view->render('cuenta/lista_row_alquiler.phtml');
                    } else {
                        $alquiler_canceladas_html .= $this->view->render('cuenta/lista_row_alquiler.phtml');
                    }
                    break;
                case 'viaje':
                    if ($c->getEstado() == 'pendiente') {
                        $viaje_pendientes_html .= $this->view->render('cuenta/lista_row_viaje.phtml');
                    } else {
                        $viaje_canceladas_html .= $this->view->render('cuenta/lista_row_viaje.phtml');
                    }
                    break;
            }
        }
        return array(
            'alquiler_pendientes' => $alquiler_pendientes_html,
            'alquiler_canceladas' => $alquiler_canceladas_html,
            'viaje_pendientes' => $viaje_pendientes_html,
            'viaje_canceladas' => $viaje_canceladas_html
        );
    }

    public function indexAction() {
        $cm = new Kashem_Model_CuentaMapper();
        $cuentas = $cm->fetchAll();
        $html = $this->_getLists($cuentas);
        $this->view->cuentas_alquiler_pendientes = $html['alquiler_pendientes'];
        $this->view->cuentas_alquiler_canceladas = $html['alquiler_canceladas'];
        $this->view->cuentas_viaje_pendientes = $html['viaje_pendientes'];
        $this->view->cuentas_viaje_canceladas = $html['viaje_canceladas'];
    }

    public function camposAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->view->campos = array(
            'primer_nombre' => 'nombre',
            'primer_apellido' => 'apellido',
            'nombre' => 'viaje',
            'fecha_salida' => 'fecha de salida',
            'fecha_regreso' => 'fecha de regreso',
            'renta' => 'fecha de renta',
            'devolucion' => 'fecha de devolucion',
            'monto' => 'monto'
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
            $cum = new Kashem_Model_CuentaMapper();
            $alquiler_pendientes_html = "";
            $alquiler_canceladas_html = "";
            $viaje_pendientes_html = "";
            $viaje_canceladas_html = "";
            switch ($campo) {
                case 'primer_nombre':
                case 'primer_apellido':
                    $cm = new Kashem_Model_ClienteMapper();
                    $clientes = $cm->fetchAllBy($campo, $valor);
                    foreach ($clientes as $c) {
                        $cuentas = $cum->fetchAllByCliente($c);
                        $html = $this->_getLists($cuentas);
                        $alquiler_pendientes_html .= $html['alquiler_pendientes'];
                        $alquiler_canceladas_html .= $html['alquiler_canceladas'];
                        $viaje_pendientes_html .= $html['viaje_pendientes'];
                        $viaje_canceladas_html .= $html['viaje_canceladas'];
                    }
                    break;
                case 'fecha_salida':
                case 'fecha_regreso':
                    $valor = date('Y-m-d', strtotime($valor));
                case 'nombre':
                    $vm = new Kashem_Model_ViajeMapper();
                    $viajes = $vm->fetchAllBy($campo, $valor);
                    foreach ($viajes as $v) {
                        $cuentas = $cum->fetchAllByViaje($v);
                        $html = $this->_getLists($cuentas);
                        $alquiler_pendientes_html .= $html['alquiler_pendientes'];
                        $alquiler_canceladas_html .= $html['alquiler_canceladas'];
                        $viaje_pendientes_html .= $html['viaje_pendientes'];
                        $viaje_canceladas_html .= $html['viaje_canceladas'];
                    }
                    break;
                case 'renta':
                case 'devolucion':
                    $valor = date('Y-m-d', strtotime($valor));
                    $am = new Kashem_Model_AlquilerMapper();
                    $alquileres = $am->fetchAllBy($campo, $valor);
                    foreach ($alquileres as $a) {
                        $cuentas = $cum->fetchAllByAlquiler($a);
                        $html = $this->_getLists($cuentas);
                        $alquiler_pendientes_html .= $html['alquiler_pendientes'];
                        $alquiler_canceladas_html .= $html['alquiler_canceladas'];
                        $viaje_pendientes_html .= $html['viaje_pendientes'];
                        $viaje_canceladas_html .= $html['viaje_canceladas'];
                    }
                    break;
                default:
                    $cuentas = $cum->fetchAllBy($campo, $valor);
                    $html = $this->_getLists($cuentas);
                    $alquiler_pendientes_html .= $html['alquiler_pendientes'];
                    $alquiler_canceladas_html .= $html['alquiler_canceladas'];
                    $viaje_pendientes_html .= $html['viaje_pendientes'];
                    $viaje_canceladas_html .= $html['viaje_canceladas'];
                    break;
            }
        } else {
            $this->getResponse()->setHttpResponseCode(405);
        }
        $this->_helper->json(array(
            'lista_viaje_pendientes' => $viaje_pendientes_html,
            'lista_viaje_canceladas' => $viaje_canceladas_html,
            'lista_alquiler_pendientes' => $alquiler_pendientes_html,
            'lista_alquiler_canceladas' => $alquiler_canceladas_html
                )
        );
    }

    public function cancelarAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $request = $this->getRequest();
        $ok = false;
        $info = "";
        if ($request->isGet()) {
            try {
                $cum = new Kashem_Model_CuentaMapper();
                $cum->pay($request->getParams());
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
            $cum = new Kashem_Model_CuentaMapper();
            $tpm = new Kashem_Model_TipoPagoMapper();
            $tipos = array();
            foreach ($tpm->fetchAll() as $t) {
                $tipos[$t->getId()] = $t->getNombre();
            }
            $this->view->campos = $tipos;
            $this->view->tipos_de_pago = $this->view->render('partials/opciones.phtml');
            $cuenta = new Kashem_Model_Cuenta();
            $cum->find($id, $cuenta);
            $this->view->cuenta = $cuenta;
            $equipos = array();
            if ($cuenta->getTipo() == 'alquiler') {
                $aem = new Kashem_Model_AlquilerEquipoMapper();
                $equipoAlquiler = $aem->fetchAllByAlquiler($cuenta->getAlquiler());
                foreach ($equipoAlquiler as $ea) {
                    $equipos[] = $ea->getEquipo();
                }
                $this->view->equipos = $equipos;
                $html = $this->view->render('cuenta/alquiler.phtml');
            }
            if ($cuenta->getTipo() == 'viaje') {
                $html = $this->view->render('cuenta/viaje.phtml');
            }
        } else {
            $this->getResponse()->setHttpResponseCode(405);
        }
        $this->_helper->json(array('html' => $html));
    }

}

