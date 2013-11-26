<?php

class Kashem_Model_GuiaViajeMapper {

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
            $this->setDbTable('Kashem_Model_DbTable_GuiaViaje');
        }
        return $this->_dbTable;
    }

    public function save(Kashem_Model_GuiaViaje $guiaViaje) {
        $data = array(
            'guia_id' => $guiaViaje->getGuia()->getId(),
            'viaje_id' => $guiaViaje->getViaje()->getId()
        );
        $this->getDbTable()->insert($data);
    }

    public function deleteByViaje($viaje) {
        $this->getDbTable()->delete(array('viaje_id = ?' => $viaje->getId()));
    }

    public function deleteByGuia($guia) {
        $this->getDbTable()->delete(array('guia_id = ?' => $guia->getId()));
    }

}

