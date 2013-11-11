<?php

class Kashem_Model_PaisMapper {

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
            $this->setDbTable('Kashem_Model_DbTable_Pais');
        }
        return $this->_dbTable;
    }

    public function find($id, Kashem_Model_Pais $pais) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $pais->setId($row->id)
                ->setNombre($row->nombre);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Kashem_Model_Pais();
            $entry->setId($row->id)
                    ->setNombre($row->nombre);
            $entries[] = $entry;
        }
        return $entries;
    }

}

