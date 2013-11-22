<?php

class Kashem_Model_TipoPagoMapper {

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
            $this->setDbTable('Kashem_Model_DbTable_TipoPago');
        }
        return $this->_dbTable;
    }

    public function save(Kashem_Model_TipoPago $tipo_pago) {
        $data = array(
            'nombre' => $tipo_pago->getNombre(),
            'descripcion' => $tipo_pago->getDescripcion()
        );
        if (null === ($id = $tipo_pago->getId())) {
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
            $entry = new Kashem_Model_TipoPago();
            $entry->setId($row->id)
                    ->setNombre($row->nombre)
                    ->setDescripcion($row->descripcion);
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
            $entry = new Kashem_Model_TipoPago();
            $entry->setId($row->id)
                    ->setNombre($row->nombre)
                    ->setDescripcion($row->descripcion);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function find($id, Kashem_Model_TipoPago $tipo_pago) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $tipo_pago->setId($row->id)
                ->setNombre($row->nombre)
                ->setDescripcion($row->descripcion);
    }

    public function getCount() {
        $result = $this->getDbTable()->getAdapter()
                ->query("SELECT COUNT(*) AS total FROM tipo_pago")
                ->fetchAll();
        return $result[0]["total"];
        ;
    }

}

