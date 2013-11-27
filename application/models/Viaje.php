<?php

class Kashem_Model_Viaje {

    protected $_id;
    protected $_nombre;
    protected $_fechaSalida;
    protected $_horaSalida;
    protected $_fechaRegreso;
    protected $_horaRegreso;
    protected $_terminado;

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid viaje property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid viaje property');
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

    public function getNombre() {
        return $this->_nombre;
    }

    public function setNombre($nombre) {
        $this->_nombre = $nombre;
        return $this;
    }

    public function getFechaSalida() {
        return $this->_fechaSalida;
    }

    public function setFechaSalida($fechaSalida) {
        $this->_fechaSalida = $fechaSalida;
        return $this;
    }

    public function getHoraSalida() {
        return $this->_horaSalida;
    }

    public function setHoraSalida($horaSalida) {
        $this->_horaSalida = $horaSalida;
        return $this;
    }

    public function getFechaRegreso() {
        return $this->_fechaRegreso;
    }

    public function setFechaRegreso($fechaRegreso) {
        $this->_fechaRegreso = $fechaRegreso;
        return $this;
    }

    public function getHoraRegreso() {
        return $this->_horaRegreso;
    }

    public function setHoraRegreso($horaRegreso) {
        $this->_horaRegreso = $horaRegreso;
        return $this;
    }

    public function getTerminado() {
        return $this->_terminado;
    }

    public function setTerminado($terminado) {
        $this->_terminado = $terminado;
        return $this;
    }

}

