<?php

class Kashem_Model_LogroMapper {

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
            $this->setDbTable('Kashem_Model_DbTable_Logro');
        }
        return $this->_dbTable;
    }

    public function find($id, Kashem_Model_Logro $logro) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $logro->setId($row->id)
                ->setNombre($row->nombre);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Kashem_Model_Logro();
            $entry->setId($row->id)
                    ->setNombre($row->nombre);
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

    public function save(Kashem_Model_Logro $logro) {
        $data = array(
            'nombre' => $logro->getNombre()
        );
        if (null === ($id = $logro->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function delete($id) {
        $this->getDbTable()->delete(array('id = ?' => $id));
    }

}

