<?php

class Kashem_Model_Cuenta {

    protected $_id;
    protected $_cliente;
    protected $_alquiler;
    protected $_viaje;
    protected $_tipoPago;
    protected $_tipo;
    protected $_estado;
    protected $_monto;

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid cuenta property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid cuenta property');
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

    public function getCliente() {
        return $this->_cliente;
    }

    public function setCliente(Kashem_Model_Cliente $cliente) {
        $this->_cliente = $cliente;
        return $this;
    }

    public function getAlquiler() {
        return $this->_alquiler;
    }

    public function setAlquiler(Kashem_Model_Alquiler $alquiler) {
        $this->_alquiler = $alquiler;
        return $this;
    }

    public function getViaje() {
        return $this->_viaje;
    }

    public function setViaje(Kashem_Model_Viaje $viaje) {
        $this->_viaje = $viaje;
        return $this;
    }

    public function getTipoPago() {
        return $this->_tipoPago;
    }

    public function setTipoPago(Kashem_Model_TipoPago $tipoPago) {
        $this->_tipoPago = $tipoPago;
        return $this;
    }

    public function getTipo() {
        return $this->_tipo;
    }

    public function setTipo($tipo) {
        $this->_tipo = $tipo;
        return $this;
    }

    public function getEstado() {
        return $this->_estado;
    }

    public function setEstado($estado) {
        $this->_estado = $estado;
        return $this;
    }

    public function getMonto() {
        return $this->_monto;
    }

    public function setMonto($monto) {
        $this->_monto = $monto;
        return $this;
    }

}

