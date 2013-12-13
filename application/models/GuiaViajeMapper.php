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

    public function exists(Kashem_Model_Guia $guia, Kashem_Model_Viaje $viaje) {
        $result = $this->getDbTable()->fetchRow("guia_id = " . $guia->getId() . " AND viaje_id = " . $viaje->getId());
        if (0 == count($result)) {
            return false;
        }
        return true;
    }

    public function save(Kashem_Model_GuiaViaje $guiaViaje) {
        $data = array(
            'guia_id' => $guiaViaje->getGuia()->getId(),
            'viaje_id' => $guiaViaje->getViaje()->getId(),
            'asistencia' => $guiaViaje->getAsistencia()
        );
        $this->getDbTable()->insert($data);
    }

    public function deleteByViaje($viaje) {
        $this->getDbTable()->delete(array('viaje_id = ?' => $viaje->getId()));
    }

    public function deleteByGuia($guia) {
        $this->getDbTable()->delete(array('guia_id = ?' => $guia->getId()));
    }

    public function fetchAllByViaje(Kashem_Model_Viaje $viaje) {
        $resultSet = $this->getDbTable()->fetchAll("viaje_id = " . $viaje->getId());
        $entries = array();
        $gm = new Kashem_Model_GuiaMapper();
        foreach ($resultSet as $row) {
            $guia = new Kashem_Model_Guia();
            $gm->find($row->guia_id, $guia);
            $entry = new Kashem_Model_GuiaViaje();
            $entry->setGuia($guia)
                    ->setViaje($viaje)
                    ->setAsistencia($row->asistencia);
            $entries[] = $entry;
        }
        return $entries;
    }

}

