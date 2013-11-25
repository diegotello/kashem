<?php

class Kashem_Model_AlquilerEquipoMapper {

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
            $this->setDbTable('Kashem_Model_DbTable_AlquilerEquipo');
        }
        return $this->_dbTable;
    }

    public function save(Kashem_Model_AlquilerEquipo $alquilerEquipo) {
        $data = array(
            'alquiler_id' => $alquilerEquipo->getAlquiler()->getId(),
            'equipo_id' => $alquilerEquipo->getEquipo()->getId()
        );
        $this->getDbTable()->insert($data);
    }

    public function fetchAllByAlquiler(Kashem_Model_Alquiler $alquiler) {
        $resultSet = $this->getDbTable()->fetchAll("alquiler_id=" . $alquiler->getId());
        $entries = array();
        $em = new Kashem_Model_EquipoMapper();
        foreach ($resultSet as $row) {
            $equipo = new Kashem_Model_Equipo();
            $em->find($row->equipo_id, $equipo);
            $entry = new Kashem_Model_AlquilerEquipo();
            $entry->setAlquiler($alquiler)
                    ->setEquipo($equipo);
            $entries[] = $entry;
        }
        return $entries;
    }

}

