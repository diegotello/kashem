<?php

class Kashem_Model_ClienteViajeMapper {

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
            $this->setDbTable('Kashem_Model_DbTable_ClienteViaje');
        }
        return $this->_dbTable;
    }

    public function enroll($params) {
        try {
            $cm = new Kashem_Model_ClienteMapper();
            $vm = new Kashem_Model_ViajeMapper();
            $cum = new Kashem_Model_CuentaMapper();
            $cliente = new Kashem_Model_Cliente();
            $viaje = new Kashem_Model_Viaje();
            $clienteViaje = new Kashem_Model_ClienteViaje();
            $cuenta = new Kashem_Model_Cuenta();
            $this->getDbTable()->getAdapter()->beginTransaction();
            $cm->find($params['cliente_id'], $cliente);
            $vm->find($params['viaje_id'], $viaje);
            $clienteViaje->setCliente($cliente);
            $clienteViaje->setViaje($viaje);
            $clienteViaje->setAsistencia(0);
            $this->save($clienteViaje);
            $cuenta->setCliente($cliente);
            $cuenta->setEstado('pendiente');
            $cuenta->setMonto($params['costo']);
            $cuenta->setTipo('viaje');
            $cuenta->setViaje($viaje);
            $cum->save($cuenta);
            $this->getDbTable()->getAdapter()->commit();
        } catch (exception $e) {
            $this->getDbTable()->getAdapter()->rollback();
            throw $e;
        }
    }

    public function save(Kashem_Model_ClienteViaje $clienteViaje) {
        if ($this->exists($clienteViaje->getCliente(), $clienteViaje->getViaje())) {
            $this->getDbTable()->delete(array('cliente_id = ?' => $clienteViaje->getCliente()->getId(), 'viaje_id = ?' => $clienteViaje->getViaje()->getId()));
        }
        $data = array(
            'cliente_id' => $clienteViaje->getCliente()->getId(),
            'viaje_id' => $clienteViaje->getViaje()->getId(),
            'asistencia' => $clienteViaje->getAsistencia()
        );
        $this->getDbTable()->insert($data);
    }

    public function exists(Kashem_Model_Cliente $cliente, Kashem_Model_Viaje $viaje) {
        $result = $this->getDbTable()->fetchRow("cliente_id = " . $cliente->getId() . " AND viaje_id = " . $viaje->getId());
        if (0 == count($result)) {
            return false;
        }
        return true;
    }

    public function fetchAllByViaje(Kashem_Model_Viaje $viaje) {
        $resultSet = $this->getDbTable()->fetchAll("viaje_id = " . $viaje->getId());
        $entries = array();
        $cm = new Kashem_Model_ClienteMapper();
        foreach ($resultSet as $row) {
            $cliente = new Kashem_Model_Cliente();
            $cm->find($row->cliente_id, $cliente);
            $entry = new Kashem_Model_ClienteViaje();
            $entry->setCliente($cliente)
                    ->setViaje($viaje)
                    ->setAsistencia($row->asistencia);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findByViajeAndCliente(Kashem_Model_ClienteViaje $clienteViaje, Kashem_Model_Viaje $viaje, Kashem_Model_Cliente $cliente) {
        $row = $this->getDbTable()->fetchRow("cliente_id = " . $cliente->getId() . " AND viaje_id = " . $viaje->getId());
        $clienteViaje->setCliente($cliente)
                ->setViaje($viaje)
                ->setAsistencia($row->asistencia);
    }

}

