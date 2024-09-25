<?php

    require_once '../clases/persona.php';
    require_once '../db.php';
    
    class ClienteDB {
        protected $dni;
        protected $telefono;
        private $conexion;

        public function __construct($conexion){
            $this->conexion = $conexion;
        }

        public function agregarCliente(Cliente $cliente) {
            $sql = "INSERT INTO clientes (nombre, apellido, dni, telefono) VALUES (:nombre, :apellido, :dni, :telefono)";
            $stmt = $this->conexion->prepare($sql);

            $nombre = $cliente->getNombre();
            $apellido = $cliente->getApellido();
            $dni = $cliente->getDni();
            $telefono = $cliente->getTelefono();

            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':dni', $dni);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->execute();
        }

        public function obtenerClientes(){
            $sql = "SELECT * FROM clientes";
            $stmt = $this->conexion->query($sql);
            $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $clientes;
        }

        public function obtenerCliente($id){
            $sql = "SELECT * FROM clientes WHERE id = :id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
            return $cliente;
        }

        public function eliminarCliente($id) {
            $sql = "DELETE FROM clientes WHERE id = :id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        }

    }

    // $persona = new Cliente("h","sdsd","sdsd","sdsd");
    // $persona->mostrarDatos();