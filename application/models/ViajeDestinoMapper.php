<?php

class Kashem_Model_ViajeDestinoMapper {

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
            $this->setDbTable('Kashem_Model_DbTable_ViajeDestino');
        }
        return $this->_dbTable;
    }

    public function save(Kashem_Model_ViajeDestino $viajeDestino) {
        $data = array(
            'destino_id' => $viajeDestino->getDestino()->getId(),
            'viaje_id' => $viajeDestino->getViaje()->getId()
        );
        $this->getDbTable()->insert($data);
    }

    public function exists(Kashem_Model_Destino $destino, Kashem_Model_Viaje $viaje) {
        $result = $this->getDbTable()->fetchRow("destino_id = " . $destino->getId() . " AND viaje_id = " . $viaje->getId());
        if (0 == count($result)) {
            return false;
        }
        return true;
    }

    public function deleteByViaje($viaje) {
        $this->getDbTable()->delete(array('viaje_id = ?' => $viaje->getId()));
    }

    public function deleteByDestino($destino) {
        $this->getDbTable()->delete(array('destino_id = ?' => $destino->getId()));
    }

    public function fetchAllByViaje(Kashem_Model_Viaje $viaje) {
        $resultSet = $this->getDbTable()->fetchAll("viaje_id = " . $viaje->getId());
        $entries = array();
        $dm = new Kashem_Model_DestinoMapper();
        foreach ($resultSet as $row) {
            $destino = new Kashem_Model_Destino();
            $dm->find($row->destino_id, $destino);
            $entry = new Kashem_Model_ViajeDestino();
            $entry->setDestino($destino)
                    ->setViaje($viaje);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllAsArray() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        $dm = new Kashem_Model_DestinoMapper();
        $vm = new Kashem_Model_ViajeMapper();
        foreach ($resultSet as $row) {
            $destino = new Kashem_Model_Destino();
            $viaje = new Kashem_Model_Viaje();
            $dm->find($row->destino_id, $destino);
            $vm->find($row->viaje_id, $viaje);
            $entry = array(
                'viaje' => $viaje->getNombre(),
                'fecha_regreso' => $viaje->getFechaRegreso(),
                'fecha_salida' => $viaje->getFechaSalida(),
                'hora_regreso' => $viaje->getHoraRegreso(),
                'hora_salida' => $viaje->getHoraSalida(),
                'terminado' => ($viaje->getTerminado() == '1') ? 'Sí' : 'No',
                'destino' => $destino->getNombre(),
                'pais' => $destino->getPais()->getNombre(),
                'departamento' => $destino->getDepartamento()->getNombre(),
                'municipio' => $destino->getMunicipio()->getNombre()
            );
            $entries[] = $entry;
        }
        return $entries;
    }

}

