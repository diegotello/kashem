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

    public function findAsArray($id) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        return $result->current();
    }

    public function save(Kashem_Model_Departamento $departamento) {
        $data = array(
            'nombre' => $departamento->getNombre(),
            'pais_id' => $departamento->getPais()->getId()
        );
        if (null === ($id = $departamento->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function delete($id) {
        $this->getDbTable()->delete(array('id = ?' => $id));
    }

    //this function only supports search by Strings!!!
    public function fetchAllBy($campo, $valor) {
        if ($campo == null) {
            $campo = 'id';
        }
        $resultSet = $this->getDbTable()->fetchAll($campo . ' LIKE "%' . $valor . '%"');
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

