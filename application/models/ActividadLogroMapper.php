<?php

class Kashem_Model_ActividadLogroMapper {

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
            $this->setDbTable('Kashem_Model_DbTable_ActividadLogro');
        }
        return $this->_dbTable;
    }

    public function save(Kashem_Model_ActividadLogro $actividadLogro) {
        $data = array(
            'actividad_id' => $actividadLogro->getActividad()->getId(),
            'logro_id' => $actividadLogro->getLogro()->getId()
        );
        $this->getDbTable()->insert($data);
    }

    public function exists(Kashem_Model_Actividad $actividad, Kashem_Model_Logro $logro) {
        $result = $this->getDbTable()->fetchRow("actividad_id = " . $actividad->getId() . " AND logro_id = " . $logro->getId());
        if (0 == count($result)) {
            return false;
        }
        return true;
    }

    public function deleteByLogro($logro) {
        $this->getDbTable()->delete(array('logro_id = ?' => $logro->getId()));
    }

    public function deleteByActividad($actividad) {
        $this->getDbTable()->delete(array('actividad_id = ?' => $actividad->getId()));
    }

}

