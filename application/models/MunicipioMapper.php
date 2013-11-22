<?php

class Kashem_Model_MunicipioMapper {

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
            $this->setDbTable('Kashem_Model_DbTable_Municipio');
        }
        return $this->_dbTable;
    }

    public function find($id, Kashem_Model_Municipio $municipio) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $dm = new Kashem_Model_DepartamentoMapper();
        $departamento = new Kashem_Model_Departamento();
        $dm->find($row->departamento_id, $departamento);
        $municipio->setId($row->id)
                ->setNombre($row->nombre)
                ->setDepartamento($departamento);
    }

    public function fetchAllByDepartamento(Kashem_Model_Departamento $departamento) {
        $resultSet = $this->getDbTable()->fetchAll("departamento_id=" . $departamento->getId());
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Kashem_Model_Municipio();
            $entry->setId($row->id)
                    ->setNombre($row->nombre)
                    ->setDepartamento($departamento);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        $dm = new Kashem_Model_DepartamentoMapper();
        foreach ($resultSet as $row) {
            $departamento = new Kashem_Model_Departamento();
            $dm->find($row->departamento_id, $departamento);
            $entry = new Kashem_Model_Municipio();
            $entry->setId($row->id)
                    ->setNombre($row->nombre)
                    ->setDepartamento($departamento);
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

    public function save(Kashem_Model_Municipio $municipio) {
        $data = array(
            'nombre' => $municipio->getNombre(),
            'departamento_id' => $municipio->getDepartamento()->getId()
        );
        if (null === ($id = $municipio->getId())) {
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
        $dm = new Kashem_Model_DepartamentoMapper();
        foreach ($resultSet as $row) {
            $departamento = new Kashem_Model_Departamento();
            $dm->find($row->departamento_id, $departamento);
            $entry = new Kashem_Model_Municipio();
            $entry->setId($row->id)
                    ->setNombre($row->nombre)
                    ->setDepartamento($departamento);
            $entries[] = $entry;
        }
        return $entries;
    }

}

