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

    private function getEntries($resultSet) {
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

    public function find($id, Kashem_Model_Cuenta $cuenta) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $am = new Kashem_Model_AlquilerMapper();
        $cm = new Kashem_Model_ClienteMapper();
        $vm = new Kashem_Model_ViajeMapper();
        $tpm = new Kashem_Model_TipoPagoMapper();
        $row = $result->current();
        $cliente = new Kashem_Model_Cliente();
        $cm->find($row->cliente_id, $cliente);
        $tipoPago = new Kashem_Model_TipoPago();
        if ($row->tipo == 'alquiler') {
            $alquiler = new Kashem_Model_Alquiler();
            $am->find($row->alquiler_id, $alquiler);
            $cuenta->setAlquiler($alquiler);
        }
        if ($row->tipo == 'viaje') {
            $viaje = new Kashem_Model_Viaje();
            $vm->find($row->viaje_id, $viaje);
            $cuenta->setViaje($viaje);
        }
        $tpm->find($row->tipo_de_pago_id, $tipoPago);
        $cuenta->setId($row->id)
                ->setCliente($cliente)
                ->setEstado($row->estado)
                ->setMonto($row->monto)
                ->setTipo($row->tipo)
                ->setTipoPago($tipoPago);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        return $this->getEntries($resultSet);
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
                'tipo_de_pago_id' => $tpid
            );
        } else {
            if ($cuenta->getTipo() == 'viaje') {
                $data = array(
                    'viaje_id' => $cuenta->getViaje()->getId(),
                    'cliente_id' => $cuenta->getCliente()->getId(),
                    'tipo' => $cuenta->getTipo(),
                    'estado' => $cuenta->getEstado(),
                    'monto' => $cuenta->getMonto(),
                    'tipo_de_pago_id' => $tpid
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

    public function fetchAllByCliente(Kashem_Model_Cliente $cliente) {
        $resultSet = $this->getDbTable()->fetchAll("cliente_id=" . $cliente->getId());
        return $this->getEntries($resultSet);
    }

    public function fetchAllByViaje(Kashem_Model_Viaje $viaje) {
        $resultSet = $this->getDbTable()->fetchAll("viaje_id=" . $viaje->getId());
        return $this->getEntries($resultSet);
    }

    public function fetchAllByAlquiler(Kashem_Model_Alquiler $alquiler) {
        $resultSet = $this->getDbTable()->fetchAll("alquiler_id=" . $alquiler->getId());
        return $this->getEntries($resultSet);
    }

    //this function only supports search by Strings!!!
    public function fetchAllBy($campo, $valor) {
        if ($campo == null) {
            $campo = 'id';
        }
        $resultSet = $this->getDbTable()->fetchAll($campo . ' LIKE "%' . $valor . '%"');
        return $this->getEntries($resultSet);
    }

    public function pay($params) {
        try {
            $id = $params['id'];
            $tipo_de_pago_id = $params['tipo_de_pago_id'];
            $tpm = new Kashem_Model_TipoPagoMapper();
            $cuenta = new Kashem_Model_Cuenta();
            $tipoPago = new Kashem_Model_TipoPago();
            $this->getDbTable()->getAdapter()->beginTransaction();
            $this->find($id, $cuenta);
            $tpm->find($tipo_de_pago_id, $tipoPago);
            if ($cuenta->getTipo() == 'alquiler') {
                $alquiler = $cuenta->getAlquiler();
                $aem = new Kashem_Model_AlquilerEquipoMapper();
                $em = new Kashem_Model_EquipoMapper();
                $alquilerEquipo = $aem->fetchAllByAlquiler($alquiler);
                foreach ($alquilerEquipo as $ae) {
                    $equipo = $ae->getEquipo();
                    $equipo->setDisponible(1);
                    $em->save($equipo);
                }
            }
            $cuenta->setEstado('cancelado');
            $cuenta->setTipoPago($tipoPago);
            $this->save($cuenta);
            $this->getDbTable()->getAdapter()->commit();
        } catch (exception $e) {
            $this->getDbTable()->getAdapter()->rollback();
            throw $e;
        }
    }

}

