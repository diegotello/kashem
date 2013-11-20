<?php

class Kashem_Model_ViajeDestinoMapper {

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
            $this->setDbTable('Kashem_Model_DbTable_ViajeDestino');
        }
        return $this->_dbTable;
    }

    public function save(Kashem_Model_ViajeDestino $viajeDestino) {
        $data = array(
            'destino_id' => $viajeDestino->getDestino()->getId(),
            'viaje_id' => $viajeDestino->getViaje()->getId()
        );
        $this->getDbTable()->insert($data);
    }

    public function exists(Kashem_Model_Destino $destino, Kashem_Model_Viaje $viaje) {
        $result = $this->getDbTable()->fetchRow("destino_id = " . $destino->getId() . " AND viaje_id = " . $viaje->getId());
        if (0 == count($result)) {
            return false;
        }
        return true;
    }

    public function deleteByViaje($viaje) {
        $this->getDbTable()->delete(array('viaje_id = ?' => $viaje->getId()));
    }

    public function deleteByDestino($destino) {
        $this->getDbTable()->delete(array('destino_id = ?' => $destino->getId()));
    }

}

