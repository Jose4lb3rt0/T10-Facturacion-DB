<?php

    require_once 'cliente.php';
    require_once 'producto.php';
    require '../db.php';

    class Factura{
        private $cliente;
        private $productos = [];
        private $conexion;

        public function __construct($conexion){
            $this->conexion = $conexion;
        }

        /*public function __construct(Cliente $cliente){
            $this->cliente = $cliente;
        }*/

        /*public function agregarProducto(Producto $producto, $cantidad){
            $this->productos[] = [
                'producto' => $producto,
                'cantidad' => $cantidad
            ];
        }*/

        public function crearFactura ($cliente, $total){
            $sql = "INSERT INTO facturas (cliente_id, total) VALUES (:cliente_id, :total)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':cliente_id', $cliente);
            $stmt->bindParam(':total', $total);
            $stmt->execute();
            /*$stmt->execute([
                "cliente_id" => $cliente,
                "total" => $total
            ]);*/
            return $this->conexion->lastInsertId();
        }

        public function agregarProductoAFactura($factura_id, $producto, $cantidad){
            $sql = "INSERT INTO factura_productos (factura_id, producto_id, cantidad) VALUES (:factura_id, :producto_id, :cantidad)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':factura_id', $factura_id);
            $stmt->bindParam(':producto_id', $producto);
            $stmt->bindParam(':cantidad', $cantidad);
            $stmt->execute();
            /*$stmt->execute([
                "factura_id" => $factura_id,
                "producto_id" => $producto,
                "cantidad" => $cantidad
            ]);*/
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

        /*public function getCliente() {
            return $this->cliente;
        }*/
    
        /*public function getProductos() {
            return $this->productos;
        }*/

        public function calcularTotal() {
            $total = 0;
            foreach ($this->productos as $item) {
                $total += $item['producto']->getPrecio() * $item['cantidad'];
            }
            return $total;
        }

        public function mostrarFactura(){
            echo $this->cliente->mostrarDatos();
            echo "Productos: <br>";
            foreach($this->productos as $producto){
                echo "Nombre: {$producto->getNombre()} Precio: {$producto->getPrecio()} <br>";
            }
            echo "Total: {$this->calcularTotal()} <br>";
        }
    }
