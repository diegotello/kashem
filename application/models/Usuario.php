<?php

class Kashem_Model_Usuario {

    protected $_id;
    protected $_nombre;
    protected $_password;
    protected $_rol;

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid usuario property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid usuario property');
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

    public function getNombre() {
        return $this->_nombre;
    }

    public function setNombre($nombre) {
        $this->_nombre = (string) $nombre;
        return $this;
    }

    public function getPassword() {
        return $this->_password;
    }

    public function setPassword($password) {
        $this->_password = $password;
        return $this;
    }

    public function getRol() {
        return $this->_rol;
    }

    public function setRol(Kashem_Model_Rol $rol) {
        $this->_rol = $rol;
        return $this;
    }

}

