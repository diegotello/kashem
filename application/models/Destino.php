<?php

class Kashem_Model_Destino {

    protected $_id;
    protected $_pais;
    protected $_departamento;
    protected $_municipio;
    protected $_nombre;
    protected $_descripcion;
    protected $_lat;
    protected $_long;

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid destino property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid destino property');
        }
        return $this->$method();
    }

    public function setOptions(array $options) {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    public function getId() {
        return $this->_id;
    }

    public function setId($id) {
        $this->_id = $id;
        return $this;
    }

    public function getPais() {
        return $this->_pais;
    }

    public function setPais(Kashem_Model_Pais $pais) {
        $this->_pais = $pais;
        return $this;
    }

    public function getDepartamento() {
        return $this->_departamento;
    }

    public function setDepartamento(Kashem_Model_Departamento $departamento) {
        $this->_departamento = $departamento;
        return $this;
    }

    public function getMunicipio() {
        return $this->_municipio;
    }

    public function setMunicipio(Kashem_Model_Municipio $municipio) {
        $this->_municipio = $municipio;
        return $this;
    }

    public function getNombre() {
        return $this->_nombre;
    }

    public function setNombre($nombre) {
        $this->_nombre = $nombre;
        return $this;
    }

    public function getDescripcion() {
        return $this->_descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->_descripcion = $descripcion;
        return $this;
    }

    public function getLat() {
        return $this->_lat;
    }

    public function setLat($lat) {
        $this->_lat = $lat;
        return $this;
    }

    public function getLong() {
        return $this->_long;
    }

    public function setLong($long) {
        $this->_long = $long;
        return $this;
    }

}

