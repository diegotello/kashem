<?php

class Kashem_Model_AlquilerMapper {

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
            $this->setDbTable('Kashem_Model_DbTable_Alquiler');
        }
        return $this->_dbTable;
    }

    public function rent($params) {
        try {
            $aem = new Kashem_Model_AlquilerEquipoMapper();
            $cm = new Kashem_Model_ClienteMapper();
            $cum = new Kashem_Model_CuentaMapper();
            $em = new Kashem_Model_EquipoMapper();
            $cliente = new Kashem_Model_Cliente();
            $alquiler = new Kashem_Model_Alquiler();
            $cuenta = new Kashem_Model_Cuenta();
            $this->getDbTable()->getAdapter()->beginTransaction();
            $cm->find($params['cliente_id'], $cliente);
            $alquiler->setCliente($cliente)
                    ->setComentario($params['comentario'])
                    ->setDeposito($params['deposito'])
                    ->setDevolucion(date('Y-m-d', strtotime($params['devolucion'])))
                    ->setRenta(date('Y-m-d', strtotime($params['renta'])));
            $this->save($alquiler);
            foreach ($params['equipo'] as $eid) {
                $equipo = new Kashem_Model_Equipo();
                $em->find($eid, $equipo);
                if ($equipo->getDisponible() != 1) {
                    throw new Exception('El equipo ' . $equipo->getIdentificador() . ' no esta disponible.');
                } else {
                    $ae = new Kashem_Model_AlquilerEquipo();
                    $ae->setAlquiler($alquiler);
                    $ae->setEquipo($equipo);
                    $aem->save($ae);
                    $equipo->setDisponible(false);
                    $em->save($equipo);
                }
            }
            $cuenta->setAlquiler($alquiler);
            $cuenta->setCliente($cliente);
            $cuenta->setEstado("pendiente");
            $cuenta->setMonto($params['costo']);
            $cuenta->setTipo("alquiler");
            $cum->save($cuenta);
            $this->getDbTable()->getAdapter()->commit();
        } catch (exception $e) {
            $this->getDbTable()->getAdapter()->rollback();
            throw $e;
        }
    }

    public function save(Kashem_Model_Alquiler $alquiler) {
        $data = array(
            'cliente_id' => $alquiler->getCliente()->getId(),
            'comentario' => $alquiler->getComentario(),
            'deposito' => $alquiler->getDeposito(),
            'devolucion' => $alquiler->getDevolucion(),
            'renta' => $alquiler->getRenta()
        );
        if (null === ($id = $alquiler->getId())) {
            unset($data['id']);
            $aid = $this->getDbTable()->insert($data);
            $alquiler->setId($aid);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

}

