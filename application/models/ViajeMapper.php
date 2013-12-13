<?php

class Kashem_Model_ViajeMapper {

    protected $_dbTable;

    public function setDbTable($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable() {
        if (null === $this->_dbTable) {
            $this->setDbTable('Kashem_Model_DbTable_Viaje');
        }
        return $this->_dbTable;
    }

    public function save(Kashem_Model_Viaje $viaje) {
        if ($viaje->getTerminado() == null) {
            $terminado = $viaje->getTerminado();
        } else {
            $terminado = 0;
        }
        $data = array(
            'nombre' => $viaje->getNombre(),
            'fecha_salida' => $viaje->getFechaSalida(),
            'fecha_regreso' => $viaje->getFechaRegreso(),
            'hora_salida' => $viaje->getHoraSalida(),
            'hora_regreso' => $viaje->getHoraRegreso(),
            'terminado' => $terminado
        );
        if (null === ($id = $viaje->getId())) {
            unset($data['id']);
            $idl = $this->getDbTable()->insert($data);
            $viaje->setId($idl);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Kashem_Model_Viaje();
            $entry->setId($row->id)
                    ->setNombre($row->nombre)
                    ->setFechaRegreso($row->fecha_regreso)
                    ->setFechaSalida($row->fecha_salida)
                    ->setHoraRegreso($row->hora_regreso)
                    ->setHoraSalida($row->hora_salida)
                    ->setTerminado($row->terminado);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllFromToday() {
        $resultSet = $this->getDbTable()->fetchAll('fecha_salida >= "' . date("Y-m-d") . '"');
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Kashem_Model_Viaje();
            $entry->setId($row->id)
                    ->setNombre($row->nombre)
                    ->setFechaRegreso($row->fecha_regreso)
                    ->setFechaSalida($row->fecha_salida)
                    ->setHoraRegreso($row->hora_regreso)
                    ->setHoraSalida($row->hora_salida)
                    ->setTerminado($row->terminado);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function find($id, Kashem_Model_Viaje $viaje) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $viaje->setId($row->id)
                ->setNombre($row->nombre)
                ->setFechaRegreso($row->fecha_regreso)
                ->setHoraRegreso($row->hora_regreso)
                ->setFechaSalida($row->fecha_salida)
                ->setHoraSalida($row->hora_salida)
                ->setTerminado($row->terminado);
    }

    public function findAsArray($id) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        return $result->current();
    }

    public function delete($id) {
        try {
            $this->getDbTable()->getAdapter()->beginTransaction();
            $vam = new Kashem_Model_ViajeActividadMapper();
            $vdm = new Kashem_Model_ViajeDestinoMapper();
            $gvm = new Kashem_Model_GuiaViajeMapper();
            $viaje = new Kashem_Model_Viaje();
            $this->find($id, $viaje);
            $vam->deleteByViaje($viaje);
            $vdm->deleteByViaje($viaje);
            $gvm->deleteByViaje($viaje);
            $this->getDbTable()->delete(array('id = ?' => $id));
            $this->getDbTable()->getAdapter()->commit();
        } catch (exception $e) {
            $this->getDbTable()->getAdapter()->rollback();
            throw $e;
        }
    }

    //this function only supports search by Strings!!!
    public function fetchAllBy($campo, $valor) {
        if ($campo == null) {
            $campo = 'id';
        }
        $resultSet = $this->getDbTable()->fetchAll($campo . ' LIKE "%' . $valor . '%"');
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Kashem_Model_Viaje();
            $entry->setId($row->id)
                    ->setNombre($row->nombre)
                    ->setFechaRegreso($row->fecha_regreso)
                    ->setFechaSalida($row->fecha_salida)
                    ->setHoraRegreso($row->hora_regreso)
                    ->setHoraSalida($row->hora_salida)
                    ->setTerminado($row->terminado);
            $entries[] = $entry;
        }
        return $entries;
    }

    //this function only supports search by Strings!!!
    public function fetchAllFromTodayBy($campo, $valor) {
        if ($campo == null) {
            $campo = 'id';
        }
        $resultSet = $this->getDbTable()->fetchAll($campo . ' LIKE "%' . $valor . '%" AND fecha_salida >= "' . date("Y-m-d") . '"');
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Kashem_Model_Viaje();
            $entry->setId($row->id)
                    ->setNombre($row->nombre)
                    ->setFechaRegreso($row->fecha_regreso)
                    ->setFechaSalida($row->fecha_salida)
                    ->setHoraRegreso($row->hora_regreso)
                    ->setHoraSalida($row->hora_salida)
                    ->setTerminado($row->terminado);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function getCount() {
        $result = $this->getDbTable()->getAdapter()
                ->query("SELECT COUNT(*) AS total FROM viaje")
                ->fetchAll();
        return $result[0]["total"];
    }

    public function create(Kashem_Model_Viaje $viaje, $params) {
        try {
            $this->getDbTable()->getAdapter()->beginTransaction();
            $this->save($viaje);
            $am = new Kashem_Model_ActividadMapper();
            $vam = new Kashem_Model_ViajeActividadMapper();
            $dm = new Kashem_Model_DestinoMapper();
            $vdm = new Kashem_Model_ViajeDestinoMapper();
            $gvm = new Kashem_Model_GuiaViajeMapper();
            $gm = new Kashem_Model_GuiaMapper();
            if (isset($params['actividad'])) {
                $actividades = $params['actividad'];
                foreach ($actividades as $id) {
                    $actividad = new Kashem_Model_Actividad();
                    $viajeActividad = new Kashem_Model_ViajeActividad();
                    $am->find($id, $actividad);
                    $viajeActividad->setActividad($actividad);
                    $viajeActividad->setViaje($viaje);
                    $vam->save($viajeActividad);
                }
            }
            if (isset($params['destino'])) {
                $destinos = $params['destino'];
                foreach ($destinos as $id) {
                    $destino = new Kashem_Model_Destino();
                    $viajeDestino = new Kashem_Model_ViajeDestino();
                    $dm->find($id, $destino);
                    $viajeDestino->setDestino($destino);
                    $viajeDestino->setViaje($viaje);
                    $vdm->save($viajeDestino);
                }
            }
            if (isset($params['guia'])) {
                $guias = $params['guia'];
                foreach ($guias as $id) {
                    $guia = new Kashem_Model_Guia();
                    $guiaViaje = new Kashem_Model_GuiaViaje();
                    $gm->find($id, $guia);
                    $guiaViaje->setGuia($guia);
                    $guiaViaje->setViaje($viaje);
                    $guiaViaje->setAsistencia(0);
                    $gvm->save($guiaViaje);
                }
            }
            $this->getDbTable()->getAdapter()->commit();
        } catch (exception $e) {
            $this->getDbTable()->getAdapter()->rollback();
            throw $e;
        }
    }

    public function update(Kashem_Model_Viaje $viaje, $params) {
        try {
            $this->getDbTable()->getAdapter()->beginTransaction();
            $this->save($viaje);
            $vam = new Kashem_Model_ViajeActividadMapper();
            $vdm = new Kashem_Model_ViajeDestinoMapper();
            $gvm = new Kashem_Model_GuiaViajeMapper();
            $vam->deleteByViaje($viaje);
            $vdm->deleteByViaje($viaje);
            $gvm->deleteByViaje($viaje);
            $am = new Kashem_Model_ActividadMapper();
            $dm = new Kashem_Model_DestinoMapper();
            $gm = new Kashem_Model_GuiaMapper();
            if (isset($params['actividad'])) {
                $actividades = $params['actividad'];
                foreach ($actividades as $id) {
                    $actividad = new Kashem_Model_Actividad();
                    $viajeActividad = new Kashem_Model_ViajeActividad();
                    $am->find($id, $actividad);
                    $viajeActividad->setActividad($actividad);
                    $viajeActividad->setViaje($viaje);
                    $vam->save($viajeActividad);
                }
            }
            if (isset($params['destino'])) {
                $destinos = $params['destino'];
                foreach ($destinos as $id) {
                    $destino = new Kashem_Model_Destino();
                    $viajeDestino = new Kashem_Model_ViajeDestino();
                    $dm->find($id, $destino);
                    $viajeDestino->setDestino($destino);
                    $viajeDestino->setViaje($viaje);
                    $vdm->save($viajeDestino);
                }
            }
            if (isset($params['guia'])) {
                $guias = $params['guia'];
                foreach ($guias as $id) {
                    $guia = new Kashem_Model_Guia();
                    $guiaViaje = new Kashem_Model_GuiaViaje();
                    $gm->find($id, $guia);
                    $guiaViaje->setGuia($guia);
                    $guiaViaje->setViaje($viaje);
                    $guiaViaje->setAsistencia(0);
                    $gvm->save($guiaViaje);
                }
            }
            $this->getDbTable()->getAdapter()->commit();
        } catch (exception $e) {
            $this->getDbTable()->getAdapter()->rollback();
            throw $e;
        }
    }

}

