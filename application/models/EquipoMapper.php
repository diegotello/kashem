<?php

class Kashem_Model_EquipoMapper {

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
            $this->setDbTable('Kashem_Model_DbTable_Equipo');
        }
        return $this->_dbTable;
    }

    public function save(Kashem_Model_Equipo $equipo) {
        $data = array(
            'nombre' => $equipo->getNombre(),
            'descripcion' => $equipo->getDescripcion(),
            'cantidad_existente' => $equipo->getCantidadExistente()
        );
        if (null === ($id = $equipo->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function delete($id) {
        $this->getDbTable()->delete(array('id = ?' => $id));
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Kashem_Model_Equipo();
            $entry->setId($row->id)
                    ->setNombre($row->nombre)
                    ->setDescripcion($row->descripcion)
                    ->setCantidadExistente($row->cantidad_existente);
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

    //this function only supports search by Strings!!!
    public function fetchAllBy($campo, $valor) {
        $resultSet = $this->getDbTable()->fetchAll($campo . ' LIKE "%' . $valor . '%"');
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Kashem_Model_Equipo();
            $entry->setId($row->id)
                    ->setNombre($row->nombre)
                    ->setDescripcion($row->descripcion)
                    ->setCantidadExistente($row->cantidad_existente);
            $entries[] = $entry;
        }
        return $entries;
    }

}

