<?php

class Kashem_Model_UsuariosfMapper {

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
            $this->setDbTable('Kashem_Model_DbTable_Usuariossf');
        }
        return $this->_dbTable;
    }

    public function save(Kashem_Model_Usuariosf $usuariosf) {
        $data = array(
            'nombre' => $usuariosf->getNombre(),
            'contrasena' => $usuariosf->getContrasena()
        );

        if (null === ($id = $usuariosf->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function find($id, Kashem_Model_Usuariosf $usuariosf) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $usuariosf->setId($row->id)
                ->setNombre($row->nombre)
                ->setContrasena($row->contrasena);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Kashem_Model_Usuariosf();
            $entry->setId($row->id)
                    ->setNombre($row->nombre)
                    ->setContrasena($row->contrasena);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchOneByNameAndPassword($nombre, $password) {
        $row = $this->getDbTable()->fetchRow('nombre="' . $nombre . '" AND contrasena="' . $password . '"');
        if ($row != null) {
            $entry = new Kashem_Model_Usuariosf();
            $entry->setId($row->id)
                    ->setNombre($row->nombre)
                    ->setContrasena($row->contrasena);
            return $entry;
        }
        return null;
    }

}

