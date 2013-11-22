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

    public function find($id, Kashem_Model_Equipo $equipo) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return null;
        }
        $row = $result->current();
        $equipo->setId($row->id)
                ->setNombre($row->nombre)
                ->setDescripcion($row->descripcion)
                ->setIdentificador($row->identificador)
                ->setDisponible($row->disponible);
    }

    public function save(Kashem_Model_Equipo $equipo) {
        $disponible = $equipo->getDisponible() !== null ? $equipo->getDisponible() : true;
        $data = array(
            'nombre' => $equipo->getNombre(),
            'descripcion' => $equipo->getDescripcion(),
            'identificador' => $equipo->getIdentificador(),
            'disponible' => $disponible
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
                    ->setIdentificador($row->identificador)
                    ->setDisponible($row->disponible);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllDisponibles() {
        $resultSet = $this->getDbTable()->fetchAll('disponible = true');
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Kashem_Model_Equipo();
            $entry->setId($row->id)
                    ->setNombre($row->nombre)
                    ->setDescripcion($row->descripcion)
                    ->setIdentificador($row->identificador)
                    ->setDisponible($row->disponible);
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
        if ($campo == null) {
            $campo = 'id';
        }
        $resultSet = $this->getDbTable()->fetchAll($campo . ' LIKE "%' . $valor . '%"');
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Kashem_Model_Equipo();
            $entry->setId($row->id)
                    ->setNombre($row->nombre)
                    ->setDescripcion($row->descripcion)
                    ->setIdentificador($row->identificador)
                    ->setDisponible($row->disponible);
            $entries[] = $entry;
        }
        return $entries;
    }

    //this function only supports search by Strings!!!
    public function fetchAllDisponiblesBy($campo, $valor) {
        if ($campo == null) {
            $campo = 'id';
        }
        $resultSet = $this->getDbTable()->fetchAll($campo . ' LIKE "%' . $valor . '%" AND disponible = true');
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Kashem_Model_Equipo();
            $entry->setId($row->id)
                    ->setNombre($row->nombre)
                    ->setDescripcion($row->descripcion)
                    ->setIdentificador($row->identificador)
                    ->setDisponible($row->disponible);
            $entries[] = $entry;
        }
        return $entries;
    }

}

