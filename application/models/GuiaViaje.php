<?php

class Kashem_Model_GuiaViaje {

    protected $_guia;
    protected $_viaje;
    protected $_asistencia;

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid guia_viaje property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid guia_viaje property');
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

    public function getGuia() {
        return $this->_guia;
    }

    public function setGuia(Kashem_Model_Guia $guia) {
        $this->_guia = $guia;
        return $this;
    }

    public function getViaje() {
        return $this->_viaje;
    }

    public function setViaje(Kashem_Model_Viaje $viaje) {
        $this->_viaje = $viaje;
        return $this;
    }

    public function getAsistencia() {
        return $this->_asistencia;
    }

    public function setAsistencia($asistencia) {
        $this->_asistencia = $asistencia;
        return $this;
    }

}

