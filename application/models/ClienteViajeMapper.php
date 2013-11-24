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
        $data = array(
            'cliente_id' => $clienteViaje->getCliente()->getId(),
            'viaje_id' => $clienteViaje->getViaje()->getId()
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

}

