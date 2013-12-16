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
                    $equipo->setDisponible(0);
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

    public function find($id, Kashem_Model_Alquiler $alquiler) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $cm = new Kashem_Model_ClienteMapper();
        $cliente = new Kashem_Model_Cliente();
        $row = $result->current();
        $cm->find($row->cliente_id, $cliente);
        $alquiler->setId($row->id)
                ->setCliente($cliente)
                ->setComentario($row->comentario)
                ->setDeposito($row->deposito)
                ->setDevolucion($row->devolucion)
                ->setRenta($row->renta);
    }

    //this function only supports search by Strings!!!
    public function fetchAllBy($campo, $valor) {
        if ($campo == null) {
            $campo = 'id';
        }
        $resultSet = $this->getDbTable()->fetchAll($campo . ' LIKE "%' . $valor . '%"');
        $entries = array();
        $cm = new Kashem_Model_ClienteMapper();
        foreach ($resultSet as $row) {
            $cliente = new Kashem_Model_Cliente();
            $cm->find($row->cliente_id, $cliente);
            $entry = new Kashem_Model_Alquiler();
            $entry->setId($row->id)
                    ->setCliente($cliente)
                    ->setComentario($row->comentario)
                    ->setDeposito($row->deposito)
                    ->setDevolucion($row->devolucion)
                    ->setRenta($row->renta);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllAsArray() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        $cm = new Kashem_Model_ClienteMapper();
        $aem = new Kashem_Model_AlquilerEquipoMapper();
        foreach ($resultSet as $row) {
            $cliente = new Kashem_Model_Cliente();
            $alquiler = new Kashem_Model_Alquiler();
            $cm->find($row->cliente_id, $cliente);
            $alquiler->setId($row->id)
                    ->setCliente($cliente)
                    ->setComentario($row->comentario)
                    ->setDeposito($row->deposito)
                    ->setDevolucion($row->devolucion)
                    ->setRenta($row->renta);
            $equipos = $aem->fetchAllByAlquiler($alquiler);
            foreach ($equipos as $ae) {
                $entry = array(
                    'alquiler' => $alquiler->getId(),
                    'dpi' => $cliente->getDpi(),
                    'fecha_nacimiento' => $cliente->getFechaNacimiento(),
                    'primer_apellido' => $cliente->getPrimerApellido(),
                    'primer_nombre' => $cliente->getPrimerNombre(),
                    'segundo_apellido' => $cliente->getSegundoApellido(),
                    'segundo_nombre' => $cliente->getSegundoNombre(),
                    'equipo' => $ae->getEquipo()->getNombre(),
                    'identificador' => $ae->getEquipo()->getIdentificador(),
                    'renta' => $alquiler->getRenta(),
                    'devolucion' => $alquiler->getDevolucion(),
                    'deposito' => $alquiler->getDeposito(),
                    'comentario' => $alquiler->getComentario()
                );
                $entries[] = $entry;
            }
        }
        return $entries;
    }

}

