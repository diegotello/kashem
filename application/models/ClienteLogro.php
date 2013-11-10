<?php

class Kashem_Model_ClienteLogro {

    protected $_cliente;
    protected $_logro;

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid cliente_logro property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid cliente_logro property');
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

    public function getCliente() {
        return $this->_cliente;
    }

    public function setCliente(Kashem_Model_Cliente $cliente) {
        $this->_cliente = $cliente;
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

