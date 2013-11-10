<?php

class Kashem_Model_Cliente {

    protected $_id;
    protected $_pais;
    protected $_departamento;
    protected $_municipio;
    protected $_primerNombre;
    protected $_segundoNombre;
    protected $_primerApellido;
    protected $_segundoApellido;
    protected $_fechaNacimiento;
    protected $_genero;
    protected $_dpi;
    protected $_telefono;
    protected $_direccion;
    protected $_correoElectronico;
    protected $_usuarioFacebook;
    protected $_contactoEmergencia;
    protected $_telefonoEmergencia;
    protected $_observacionMedica;
    protected $_observacionGeneral;

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid cliente property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid cliente property');
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

    public function getPrimerNombre() {
        return $this->_primerNombre;
    }

    public function setPrimerNombre($primerNombre) {
        $this->_primerNombre = $primerNombre;
        return $this;
    }

    public function getSegundoNombre() {
        return $this->_segundoNombre;
    }

    public function setSegundoNombre($segundoNombre) {
        $this->_segundoNombre = $segundoNombre;
        return $this;
    }

    public function getPrimerApellido() {
        return $this->_primerApellido;
    }

    public function setPrimerApellido($primerApellido) {
        $this->_primerApellido = $primerApellido;
        return $this;
    }

    public function getSegundoApellido() {
        return $this->_segundoApellido;
    }

    public function setSegundoApellido($segundoApellido) {
        $this->_segundoApellido = $segundoApellido;
        return $this;
    }

    public function getFechaNacimiento() {
        return $this->_fechaNacimiento;
    }

    public function setFechaNacimiento($fechaNacimiento) {
        $this->_fechaNacimiento = $fechaNacimiento;
        return $this;
    }

    public function getGenero() {
        return $this->_genero;
    }

    public function setGenero($genero) {
        $this->_genero = $genero;
        return $this;
    }

    public function getDpi() {
        return $this->_dpi;
    }

    public function setDpi($dpi) {
        $this->_dpi = $dpi;
        return $this;
    }

    public function getTelefono() {
        return $this->_telefono;
    }

    public function setTelefono($telefono) {
        $this->_telefono = $telefono;
        return $this;
    }

    public function getDireccion() {
        return $this->_direccion;
    }

    public function setDireccion($direccion) {
        $this->_direccion = $direccion;
        return $this;
    }

    public function getCorreoElectronico() {
        return $this->_correoElectronico;
    }

    public function setCorreoElectronico($correoElectronico) {
        $this->_correoElectronico = $correoElectronico;
        return $this;
    }

    public function getUsuarioFacebook() {
        return $this->_usuarioFacebook;
    }

    public function setUsuarioFacebook($usuarioFacebook) {
        $this->_usuarioFacebook = $usuarioFacebook;
        return $this;
    }

    public function getContactoEmergencia() {
        return $this->_contactoEmergencia;
    }

    public function setContactoEmergencia($contactoEmergencia) {
        $this->_contactoEmergencia = $contactoEmergencia;
        return $this;
    }

    public function getTelefonoEmergencia() {
        return $this->_telefonoEmergencia;
    }

    public function setTelefonoEmergencia($telefonoEmergencia) {
        $this->_telefonoEmergencia = $telefonoEmergencia;
        return $this;
    }

    public function getObservacionMedica() {
        return $this->_observacionMedica;
    }

    public function setObservacionMedica($observacionMedica) {
        $this->_observacionMedica = $observacionMedica;
        return $this;
    }

    public function getObservacionGeneral() {
        return $this->_observacionGeneral;
    }

    public function setObservacionGeneral($observacionGeneral) {
        $this->_observacionGeneral = $observacionGeneral;
        return $this;
    }

}

