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

}

