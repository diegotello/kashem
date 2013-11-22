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

