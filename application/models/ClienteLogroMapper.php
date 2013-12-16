<?php

class Kashem_Model_ClienteLogroMapper {

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
            $this->setDbTable('Kashem_Model_DbTable_ClienteLogro');
        }
        return $this->_dbTable;
    }

    public function save(Kashem_Model_ClienteLogro $clienteLogro) {
        if (!$this->exists($clienteLogro->getCliente(), $clienteLogro->getLogro())) {
            $data = array(
                'cliente_id' => $clienteLogro->getCliente()->getId(),
                'logro_id' => $clienteLogro->getLogro()->getId()
            );
            $this->getDbTable()->insert($data);
        }
    }

    public function exists(Kashem_Model_Cliente $cliente, Kashem_Model_Logro $logro) {
        $result = $this->getDbTable()->fetchRow("cliente_id = " . $cliente->getId() . " AND logro_id = " . $logro->getId());
        if (0 == count($result)) {
            return false;
        }
        return true;
    }

    public function fetchAllAsArray() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        $cm = new Kashem_Model_ClienteMapper();
        $lm = new Kashem_Model_LogroMapper();
        foreach ($resultSet as $row) {
            $cliente = new Kashem_Model_Cliente();
            $logro = new Kashem_Model_Logro();
            $cm->find($row->cliente_id, $cliente);
            $lm->find($row->logro_id, $logro);
            $entry = array(
                'dpi' => $cliente->getDpi(),
                'fecha_nacimiento' => $cliente->getFechaNacimiento(),
                'primer_apellido' => $cliente->getPrimerApellido(),
                'primer_nombre' => $cliente->getPrimerNombre(),
                'segundo_apellido' => $cliente->getSegundoApellido(),
                'segundo_nombre' => $cliente->getSegundoNombre(),
                'logro' => $logro->getNombre()
            );
            $entries[] = $entry;
        }
        return $entries;
    }

}

