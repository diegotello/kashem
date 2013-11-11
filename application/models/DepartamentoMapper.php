<?php

class Kashem_Model_DepartamentoMapper {

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
            $this->setDbTable('Kashem_Model_DbTable_Departamento');
        }
        return $this->_dbTable;
    }

    public function find($id, Kashem_Model_Departamento $departamento) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $pm = new Kashem_Model_PaisMapper();
        $pais = new Kashem_Model_Pais();
        $pm->find($row->pais_id, $pais);
        $departamento->setId($row->id)
                ->setNombre($row->nombre)
                ->setPais($pais);
    }

    public function fetchAllByPais(Kashem_Model_Pais $pais) {
        $resultSet = $this->getDbTable()->fetchAll("pais_id=" . $pais->getId());
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Kashem_Model_Departamento();
            $entry->setId($row->id)
                    ->setNombre($row->nombre)
                    ->setPais($pais);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        $pm = new Kashem_Model_PaisMapper();
        foreach ($resultSet as $row) {
            $pais = new Kashem_Model_Pais();
            $pm->find($row->pais_id, $pais);
            $entry = new Kashem_Model_Departamento();
            $entry->setId($row->id)
                    ->setNombre($row->nombre)
                    ->setPais($pais);
            $entries[] = $entry;
        }
        return $entries;
    }

}
