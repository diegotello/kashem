<?php

class Kashem_Model_GuiaMapper {

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
            $this->setDbTable('Kashem_Model_DbTable_Guia');
        }
        return $this->_dbTable;
    }

    public function find($id, Kashem_Model_Guia $guia) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $cm = new Kashem_Model_ClienteMapper();
        $cam = new Kashem_Model_CategoriaMapper();
        $cliente = new Kashem_Model_Cliente();
        $categoria = new Kashem_Model_Categoria();
        $cm->find($row->cliente_id, $cliente);
        $cam->find($row->categoria_id, $categoria);
        $guia->setId($row->id)
                ->setCliente($cliente)
                ->setCategoria($categoria);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        $cm = new Kashem_Model_ClienteMapper();
        $cam = new Kashem_Model_CategoriaMapper();
        foreach ($resultSet as $row) {
            $cliente = new Kashem_Model_Cliente();
            $categoria = new Kashem_Model_Categoria();
            $cm->find($row->cliente_id, $cliente);
            $cam->find($row->categoria_id, $categoria);
            $entry = new Kashem_Model_Guia();
            $entry->setId($row->id)
                    ->setCliente($cliente)
                    ->setCategoria($categoria);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Kashem_Model_Guia $guia) {
        $data = array(
            'cliente_id' => $guia->getCliente()->getId(),
            'categoria_id' => $guia->getCategoria()->getId()
        );
        if (null === ($id = $guia->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function fetchByCliente(Kashem_Model_Cliente $cliente) {
        $row = $this->getDbTable()->fetchRow("cliente_id=" . $cliente->getId());
        $entry = null;
        if ($row != null) {
            $cam = new Kashem_Model_CategoriaMapper();
            $categoria = new Kashem_Model_Categoria();
            $cam->find($row->categoria_id, $categoria);
            $entry = new Kashem_Model_Guia();
            $entry->setId($row->id)
                    ->setCliente($cliente)
                    ->setCategoria($categoria);
        }
        return $entry;
    }

    public function fetchAllByCategoria(Kashem_Model_Categoria $categoria) {
        $resultSet = $this->getDbTable()->fetchAll("categoria_id=" . $categoria->getId());
        $entries = array();
        $cm = new Kashem_Model_ClienteMapper();
        $cam = new Kashem_Model_CategoriaMapper();
        foreach ($resultSet as $row) {
            $cliente = new Kashem_Model_Cliente();
            $categoria = new Kashem_Model_Categoria();
            $cm->find($row->cliente_id, $cliente);
            $cam->find($row->categoria_id, $categoria);
            $entry = new Kashem_Model_Guia();
            $entry->setId($row->id)
                    ->setCliente($cliente)
                    ->setCategoria($categoria);
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

    public function delete($id) {
        $this->getDbTable()->delete(array('id = ?' => $id));
    }

}

