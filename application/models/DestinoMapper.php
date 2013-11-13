<?php

class Kashem_Model_DestinoMapper {

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
            $this->setDbTable('Kashem_Model_DbTable_Destino');
        }
        return $this->_dbTable;
    }

    public function save(Kashem_Model_Destino $destino) {
        $data = array(
            'pais_id' => $destino->getPais()->getId(),
            'departamento_id' => $destino->getDepartamento()->getId(),
            'municipio_id' => $destino->getMunicipio()->getId(),
            'nombre' => $destino->getNombre(),
            'descripcion' => $destino->getDescripcion()
        );

        if (null === ($id = $destino->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function delete($id) {
        $this->getDbTable()->delete(array('id = ?' => $id));
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        $pm = new Kashem_Model_PaisMapper();
        $dm = new Kashem_Model_DepartamentoMapper();
        $mm = new Kashem_Model_MunicipioMapper();
        foreach ($resultSet as $row) {
            $pais = new Kashem_Model_Pais();
            $departamento = new Kashem_Model_Departamento();
            $municipio = new Kashem_Model_Municipio();
            $pm->find($row->pais_id, $pais);
            $dm->find($row->departamento_id, $departamento);
            $mm->find($row->municipio_id, $municipio);
            $entry = new Kashem_Model_Destino();
            $entry->setId($row->id)
                    ->setDepartamento($departamento)
                    ->setMunicipio($municipio)
                    ->setPais($pais)
                    ->setDescripcion($row->descripcion)
                    ->setNombre($row->nombre);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function find($id, Kashem_Model_Destino $destino) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $pm = new Kashem_Model_PaisMapper();
        $dm = new Kashem_Model_DepartamentoMapper();
        $mm = new Kashem_Model_MunicipioMapper();
        $pais = new Kashem_Model_Pais();
        $departamento = new Kashem_Model_Departamento();
        $municipio = new Kashem_Model_Municipio();
        $pm->find($row->pais_id, $pais);
        $dm->find($row->departamento_id, $departamento);
        $mm->find($row->municipio_id, $municipio);
        $destino->setId($row->id)
                ->setContactoEmergencia($row->contacto_emergencia)
                ->setCorreoElectronico($row->correo_electronico)
                ->setDepartamento($departamento)
                ->setDireccion($row->direccion)
                ->setDpi($row->dpi)
                ->setFechaNacimiento($row->fecha_nacimiento)
                ->setGenero($row->genero)
                ->setMunicipio($municipio)
                ->setObservacionGeneral($row->observacion_general)
                ->setObservacionMedica($row->observacion_medica)
                ->setPais($pais)
                ->setPrimerApellido($row->primer_apellido)
                ->setPrimerNombre($row->primer_nombre)
                ->setSegundoApellido($row->segundo_apellido)
                ->setSegundoNombre($row->segundo_nombre)
                ->setTelefonoEmergencia($row->telefono_emergencia)
                ->setTelefono($row->telefono)
                ->setUsuarioFacebook($row->usuario_facebook);
    }

    public function findAsArray($id) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        return $result->current();
    }

}

