<?php

class Kashem_Model_AlquilerEquipo {

    protected $_alquiler;
    protected $_equipo;

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid alquiler_equipo property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid alquiler_equipo property');
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

    public function getAlquiler() {
        return $this->_alquiler;
    }

    public function setAlquiler(Kashem_Model_Alquiler $alquiler) {
        $this->_alquiler = $alquiler;
        return $this;
    }

    public function getEquipo() {
        return $this->_equipo;
    }

    public function setEquipo(Kashem_Model_Equipo $equipo) {
        $this->_equipo = $equipo;
        return $this;
    }

}

