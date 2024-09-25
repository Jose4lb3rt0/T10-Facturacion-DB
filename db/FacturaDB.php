<?php

    require_once '../clases/cliente.php';
    require_once '../clases/producto.php';
    require '../db.php';

    class FacturaDB {
        private $conexion;

        public function __construct($conexion){
            $this->conexion = $conexion;
        }

        public function crearFactura ($cliente, $total){
            $sql = "INSERT INTO facturas (cliente_id, total) VALUES (:cliente_id, :total)";
            $stmt = $this->conexion->prepare($sql);


            $stmt->bindParam(':cliente_id', $cliente);
            $stmt->bindParam(':total', $total);
            $stmt->execute();
            return $this->conexion->lastInsertId();
        }

        public function agregarProductoAFactura($factura_id, $producto, $cantidad){
            $sql = "INSERT INTO factura_productos (factura_id, producto_id, cantidad) VALUES (:factura_id, :producto_id, :cantidad)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':factura_id', $factura_id);
            $stmt->bindParam(':producto_id', $producto);
            $stmt->bindParam(':cantidad', $cantidad);
            $stmt->execute();
        }

        public function obtenerFacturas(){
            $sql = "SELECT * FROM facturas";
            $stmt = $this->conexion->query($sql);
            $facturas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $facturas;
        }

        public function obtenerFactura($id){
            $sql = "SELECT * FROM facturas WHERE id = :id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $factura = $stmt->fetch(PDO::FETCH_ASSOC);
            return $factura;
        }

        public function obtenerProductosDeFactura($factura_id){
            $sql = "SELECT * FROM factura_productos WHERE factura_id = :factura_id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':factura_id', $factura_id);
            $stmt->execute();
            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $productos;
        }

        public function eliminarFactura($id){
            $sql = "DELETE FROM factura_productos WHERE factura_id = :factura_id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':factura_id', $id);
            $stmt->execute();

            $sql = "DELETE FROM facturas WHERE id = :id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        }
    }
