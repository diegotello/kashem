<?php

class Kashem_Model_RolMapper {

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
            $this->setDbTable('Kashem_Model_DbTable_Rol');
        }
        return $this->_dbTable;
    }

    public function save(Kashem_Model_Rol $rol) {
        $data = array(
            'descripcion' => $rol->getDescripcion()
        );

        if (null === ($id = $rol->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function find($id, Kashem_Model_Rol $rol) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $rol->setId($row->id)
                ->setDescripcion($row->descripcion);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Kashem_Model_Rol();
            $entry->setId($row->id)
                    ->setDescripcion($row->descripcion);
            $entries[] = $entry;
        }
        return $entries;
    }

}

