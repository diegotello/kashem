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
        $aem = new Kashem_Model_AlquilerEquipoMapper();
        $cm = new Kashem_Model_ClienteMapper();
        $cum = new Kashem_Model_CuentaMapper();
        $em = new Kashem_Model_EquipoMapper();
    }

}

