<?php

require_once 'persona.php';

class Cliente extends Persona {
    protected $dni;
    protected $telefono;

    public function __construct($nombre, $apellido, $dni, $telefono) {
        parent::__construct($nombre, $apellido);
        $this->dni = $dni;
        $this->telefono = $telefono;
    }

    public function getDni() {
        return $this->dni;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function mostrarDatos() {
        echo "Cliente: {$this->getNombre()} {$this->getApellido()} DNI: {$this->getDni()} Teléfono: {$this->getTelefono()}<br>";
    }
}
