<?php

class Kashem_Model_ViajeActividadMapper {

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
            $this->setDbTable('Kashem_Model_DbTable_ViajeActividad');
        }
        return $this->_dbTable;
    }

    public function save(Kashem_Model_ViajeActividad $viajeActividad) {
        $data = array(
            'actividad_id' => $viajeActividad->getActividad()->getId(),
            'viaje_id' => $viajeActividad->getViaje()->getId()
        );
        $this->getDbTable()->insert($data);
    }

    public function exists(Kashem_Model_Actividad $actividad, Kashem_Model_Viaje $viaje) {
        $result = $this->getDbTable()->fetchRow("actividad_id = " . $actividad->getId() . " AND viaje_id = " . $viaje->getId());
        if (0 == count($result)) {
            return false;
        }
        return true;
    }

    public function deleteByViaje($viaje) {
        $this->getDbTable()->delete(array('viaje_id = ?' => $viaje->getId()));
    }

    public function deleteByActividad($actividad) {
        $this->getDbTable()->delete(array('actividad_id = ?' => $actividad->getId()));
    }

    public function fetchAllByViaje(Kashem_Model_Viaje $viaje) {
        $resultSet = $this->getDbTable()->fetchAll("viaje_id = " . $viaje->getId());
        $entries = array();
        $am = new Kashem_Model_ActividadMapper();
        foreach ($resultSet as $row) {
            $actividad = new Kashem_Model_Actividad();
            $am->find($row->actividad_id, $actividad);
            $entry = new Kashem_Model_ViajeActividad();
            $entry->setActividad($actividad)
                    ->setViaje($viaje);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllAsArray() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        $am = new Kashem_Model_ActividadMapper();
        $vm = new Kashem_Model_ViajeMapper();
        foreach ($resultSet as $row) {
            $actividad = new Kashem_Model_Actividad();
            $viaje = new Kashem_Model_Viaje();
            $am->find($row->actividad_id, $actividad);
            $vm->find($row->viaje_id, $viaje);
            $entry = array(
                'viaje' => $viaje->getNombre(),
                'fecha_regreso' => $viaje->getFechaRegreso(),
                'fecha_salida' => $viaje->getFechaSalida(),
                'hora_regreso' => $viaje->getHoraRegreso(),
                'hora_salida' => $viaje->getHoraSalida(),
                'terminado' => ($viaje->getTerminado() == '1') ? 'Sí' : 'No',
                'actividad' => $actividad->getNombre()
            );
            $entries[] = $entry;
        }
        return $entries;
    }

}

