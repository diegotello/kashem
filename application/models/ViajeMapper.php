<?php

class Kashem_Model_ViajeMapper {

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
            $this->setDbTable('Kashem_Model_DbTable_Viaje');
        }
        return $this->_dbTable;
    }

    public function save(Kashem_Model_Viaje $viaje) {
        $data = array(
            'nombre' => $viaje->getNombre(),
            'fecha_salida' => $viaje->getFechaSalida(),
            'fecha_regreso' => $viaje->getFechaRegreso(),
            'hora_salida' => $viaje->getHoraSalida(),
            'hora_regreso' => $viaje->getHoraRegreso()
        );
        if (null === ($id = $viaje->getId())) {
            unset($data['id']);
            $idl = $this->getDbTable()->insert($data);
            $viaje->setId($idl);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Kashem_Model_Viaje();
            $entry->setId($row->id)
                    ->setNombre($row->nombre)
                    ->setFechaRegreso($row->fecha_regreso)
                    ->setFechaSalida($row->fecha_salida)
                    ->setHoraRegreso($row->hora_regreso)
                    ->setHoraSalida($row->hora_salida);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllFromToday() {
        $resultSet = $this->getDbTable()->fetchAll('fecha_salida >= "' . date("Y-m-d") . '"');
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Kashem_Model_Viaje();
            $entry->setId($row->id)
                    ->setNombre($row->nombre)
                    ->setFechaRegreso($row->fecha_regreso)
                    ->setFechaSalida($row->fecha_salida)
                    ->setHoraRegreso($row->hora_regreso)
                    ->setHoraSalida($row->hora_salida);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function find($id, Kashem_Model_Viaje $viaje) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $viaje->setId($row->id)
                ->setNombre($row->nombre)
                ->setFechaRegreso($row->fecha_regreso)
                ->setHoraRegreso($row->hora_regreso)
                ->setFechaSalida($row->fecha_salida)
                ->setHoraSalida($row->hora_salida);
    }

    public function findAsArray($id) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        return $result->current();
    }

    public function delete($id) {
        $vam = new Kashem_Model_ViajeActividadMapper();
        $vdm = new Kashem_Model_ViajeDestinoMapper();
        $viaje = new Kashem_Model_Viaje();
        $this->find($id, $viaje);
        $vam->deleteByViaje($viaje);
        $vdm->deleteByViaje($viaje);
        $this->getDbTable()->delete(array('id = ?' => $id));
    }

    //this function only supports search by Strings!!!
    public function fetchAllBy($campo, $valor) {
        if ($campo == null) {
            $campo = 'id';
        }
        $resultSet = $this->getDbTable()->fetchAll($campo . ' LIKE "%' . $valor . '%"');
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Kashem_Model_Viaje();
            $entry->setId($row->id)
                    ->setNombre($row->nombre)
                    ->setFechaRegreso($row->fecha_regreso)
                    ->setFechaSalida($row->fecha_salida)
                    ->setHoraRegreso($row->hora_regreso)
                    ->setHoraSalida($row->hora_salida);
            $entries[] = $entry;
        }
        return $entries;
    }

    //this function only supports search by Strings!!!
    public function fetchAllFromTodayBy($campo, $valor) {
        if ($campo == null) {
            $campo = 'id';
        }
        $resultSet = $this->getDbTable()->fetchAll($campo . ' LIKE "%' . $valor . '%" AND fecha_salida >= "' . date("Y-m-d") . '"');
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Kashem_Model_Viaje();
            $entry->setId($row->id)
                    ->setNombre($row->nombre)
                    ->setFechaRegreso($row->fecha_regreso)
                    ->setFechaSalida($row->fecha_salida)
                    ->setHoraRegreso($row->hora_regreso)
                    ->setHoraSalida($row->hora_salida);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function getCount() {
        $result = $this->getDbTable()->getAdapter()
                ->query("SELECT COUNT(*) AS total FROM viaje")
                ->fetchAll();
        return $result[0]["total"];
        ;
    }

}

