<?php

class Kashem_Model_ActividadLogro {

    protected $_actividad;
    protected $_logro;

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid actividad_logro property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid actividad_logro property');
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

    public function getActividad() {
        return $this->_actividad;
    }

    public function setActividad(Kashem_Model_Actividad $actividad) {
        $this->_actividad = $actividad;
        return $this;
    }

    public function getLogro() {
        return $this->_logro;
    }

    public function setLogro(Kashem_Model_Logro $logro) {
        $this->_logro = $logro;
        return $this;
    }

}

