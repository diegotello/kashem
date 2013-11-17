<?php

class Kashem_Model_UsuarioMapper {

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
            $this->setDbTable('Kashem_Model_DbTable_Usuario');
        }
        return $this->_dbTable;
    }

    public function save(Kashem_Model_Usuario $usuario) {
        $data = array(
            'nombre' => $usuario->getNombre(),
            'password' => $usuario->getPassword(),
            'rol_id' => $usuario->getRol()->getId()
        );

        if (null === ($id = $usuario->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function find($id, Kashem_Model_Usuario $usuario) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $rm = new Kashem_Model_RolMapper();
        $rol = new Kashem_Model_Rol();
        $rm->find($row->rol_id, $rol);
        $usuario->setId($row->id)
                ->setNombre($row->nombre)
                ->setPassword($row->password)
                ->setRol($rol);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        $rm = new Kashem_Model_RolMapper();
        foreach ($resultSet as $row) {
            $rol = new Kashem_Model_Rol();
            $rm->find($row->rol_id, $rol);
            $entry = new Kashem_Model_Usuario();
            $entry->setId($row->id)
                    ->setNombre($row->nombre)
                    ->setPassword($row->password)
                    ->setRol($rol);
            $entries[] = $entry;
        }
        return $entries;
    }

    //this function only supports search by Strings!!!
    public function fetchAllBy($campo, $valor) {
        $resultSet = $this->getDbTable()->fetchAll($campo . ' LIKE "%' . $valor . '%"');
        $entries = array();
        $rm = new Kashem_Model_RolMapper();
        foreach ($resultSet as $row) {
            $rol = new Kashem_Model_Rol();
            $rm->find($row->rol_id, $rol);
            $entry = new Kashem_Model_Usuario();
            $entry->setId($row->id)
                    ->setNombre($row->nombre)
                    ->setPassword($row->password)
                    ->setRol($rol);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchOneByNameAndPassword($nombre, $password) {
        $row = $this->getDbTable()->fetchRow('nombre="' . $nombre . '" AND password="' . $password . '"');
        $rm = new Kashem_Model_RolMapper();
        if ($row != null) {
            $rol = new Kashem_Model_Rol();
            $rm->find($row->rol_id, $rol);
            $entry = new Kashem_Model_Usuario();
            $entry->setId($row->id)
                    ->setNombre($row->nombre)
                    ->setPassword($row->password)
                    ->setRol($rol);
            return $entry;
        }
        return null;
    }

    public function findAsArray($id) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        return $result->current();
    }

    public function delete($id) {
        $this->getDbTable()->delete(array('id = ?' => $id));
    }

}

