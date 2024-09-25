<?php

    require_once '../db.php';
    require_once '../clases/producto.php';

    class ProductoDB {
        private $conexion;

        public function __construct($conexion){
            $this->conexion = $conexion;
        }

        public function agregarProducto(Producto $producto){
            $sql = "INSERT INTO productos (nombre, precio) VALUES (:nombre, :precio)";
            $stmt = $this->conexion->prepare($sql);

            $nombre = $producto->getNombre();
            $precio = $producto->getPrecio();

            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':precio', $precio);
            $stmt->execute();
        }

        public function obtenerProductos(){
            $sql = "SELECT * FROM productos";
            $stmt = $this->conexion->query($sql);
            $productosData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $productos = [];
            foreach($productosData as $productoData){
                $producto = new Producto($productoData['nombre'], $productoData['precio']);
                $productos[$productoData['id']] = $producto;
            }

            return $productos;
        }

        public function obtenerProducto($id){
            $sql = "SELECT * FROM productos WHERE id = :id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $productoData = $stmt->fetch(PDO::FETCH_ASSOC);

            if($productoData){
                return new Producto($productoData['nombre'], $productoData['precio']);
            }

            return null;
        }

        public function eliminarProducto($id){
            $sql = "DELETE FROM productos WHERE id = :id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        }
    }