<?php

class Kashem_Model_CuentaMapper {

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
            $this->setDbTable('Kashem_Model_DbTable_Cuenta');
        }
        return $this->_dbTable;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $am = new Kashem_Model_AlquilerMapper();
        $cm = new Kashem_Model_ClienteMapper();
        $vm = new Kashem_Model_ViajeMapper();
        $tpm = new Kashem_Model_TipoPagoMapper();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Kashem_Model_Cuenta();
            $cliente = new Kashem_Model_Cliente();
            $cm->find($row->cliente_id, $cliente);
            $tipoPago = new Kashem_Model_TipoPago();
            if ($row->tipo == 'alquiler') {
                $alquiler = new Kashem_Model_Alquiler();
                $am->find($row->alquiler_id, $alquiler);
                $entry->setAlquiler($alquiler);
            }
            if ($row->tipo == 'viaje') {
                $viaje = new Kashem_Model_Viaje();
                $vm->find($row->viaje_id, $viaje);
                $entry->setViaje($viaje);
            }
            $tpm->find($row->tipo_de_pago_id, $tipoPago);
            $entry->setId($row->id)
                    ->setCliente($cliente)
                    ->setEstado($row->estado)
                    ->setMonto($row->monto)
                    ->setTipo($row->tipo)
                    ->setTipoPago($tipoPago);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Kashem_Model_Cuenta $cuenta) {
        $tpid = null;
        if ($cuenta->getTipoPago() != null) {
            $tpid = $cuenta->getTipoPago()->getId();
        }
        if ($cuenta->getTipo() == 'alquiler') {
            $data = array(
                'alquiler_id' => $cuenta->getAlquiler()->getId(),
                'cliente_id' => $cuenta->getCliente()->getId(),
                'tipo' => $cuenta->getTipo(),
                'estado' => $cuenta->getEstado(),
                'monto' => $cuenta->getMonto(),
                'tipo_de_pago_id' => $cuenta->getTipoPago()
            );
        } else {
            if ($cuenta->getTipo() == 'viaje') {
                $data = array(
                    'viaje_id' => $cuenta->getViaje()->getId(),
                    'cliente_id' => $cuenta->getCliente()->getId(),
                    'tipo' => $cuenta->getTipo(),
                    'estado' => $cuenta->getEstado(),
                    'monto' => $cuenta->getMonto(),
                    'tipo_de_pago_id' => $cuenta->getTipoPago()
                );
            }
        }
        if (null === ($id = $cuenta->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

}

