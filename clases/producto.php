<?php

require '../db.php';

class Producto {
    private $nombre;
    private $precio;
    private $conexion;

    public function __construct($conexion){
        $this->conexion = $conexion;
    }

    public function agregarProducto($nombre, $precio){
        $sql = "INSERT INTO productos (nombre, precio) VALUES (:nombre, :precio)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':precio', $precio);
        $stmt->execute();
        $stmt->execute([
            "nombre" => $nombre,
            "precio" => $precio
        ]);
    }

    public function obtenerProductos(){
        $sql = "SELECT * FROM productos";
        $stmt = $this->conexion->query($sql);
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $productos;
    }

    /*public function __construct($nombre, $precio) {
        $this->nombre = $nombre;
        $this->precio = $precio;
    }*/

    public function eliminarProducto($id){
        $sql = "DELETE FROM productos WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getPrecio() {
        return $this->precio;
    }
}

// $productos = [
//     new Producto("Coca-Cola 1L", 5.00),
//     new Producto("Doritos", 2.00),
//     new Producto("Inca Kola 1L", 3.00),
//     new Producto("Agua 500ml", 1.80),
//     new Producto("Cifrut", 1.80),
//     new Producto("Galletas Casino", 1.80),
//     new Producto("Chocolate", 2.00),
// ];