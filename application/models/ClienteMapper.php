<?php

class Kashem_Model_ClienteMapper {

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
            $this->setDbTable('Kashem_Model_DbTable_Cliente');
        }
        return $this->_dbTable;
    }

    public function save(Kashem_Model_Cliente $cliente) {
        $data = array(
            'pais_id' => $cliente->getPais()->getId(),
            'departamento_id' => $cliente->getDepartamento()->getId(),
            'municipio_id' => $cliente->getMunicipio()->getId(),
            'primer_nombre' => $cliente->getPrimerNombre(),
            'primer_apellido' => $cliente->getPrimerApellido(),
            'segundo_nombre' => $cliente->getSegundoNombre(),
            'segundo_apellido' => $cliente->getSegundoApellido(),
            'fecha_nacimiento' => $cliente->getFechaNacimiento(),
            'genero' => $cliente->getGenero(),
            'dpi' => $cliente->getDpi(),
            'telefono' => $cliente->getTelefono(),
            'direccion' => $cliente->getDireccion(),
            'correo_electronico' => $cliente->getCorreoElectronico(),
            'usuario_facebook' => $cliente->getUsuarioFacebook(),
            'contacto_emergencia' => $cliente->getContactoEmergencia(),
            'telefono_emergencia' => $cliente->getTelefonoEmergencia(),
            'observacion_medica' => $cliente->getObservacionMedica(),
            'observacion_general' => $cliente->getObservacionGeneral()
        );

        if (null === ($id = $cliente->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

}

