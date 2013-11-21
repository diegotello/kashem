<?php

class Kashem_Model_Alquiler {

    protected $_id;
    protected $_cliente;
    protected $_renta;
    protected $_devolucion;
    protected $_deposito;
    protected $_comentario;

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid alquiler property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid alquiler property');
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
        $this->_id = (int) $id;
        return $this;
    }

    public function getCliente() {
        return $this->_cliente;
    }

    public function setCliente(Kashem_Model_Cliente $cliente) {
        $this->_cliente = $cliente;
        return $this;
    }

    public function getRenta() {
        return $this->_renta;
    }

    public function setRenta($renta) {
        $this->_renta = $renta;
        return $this;
    }

    public function getDevolucion() {
        return $this->_devolucion;
    }

    public function setDevolucion($devolucion) {
        $this->_devolucion = $devolucion;
        return $this;
    }

    public function getDeposito() {
        return $this->_deposito;
    }

    public function setDeposito($deposito) {
        $this->_deposito = $deposito;
        return $this;
    }

    public function getComentario() {
        return $this->_comentario;
    }

    public function setComentario($comentario) {
        $this->_comentario = $comentario;
        return $this;
    }

}

