<?php

    require_once 'cliente.php';
    require_once 'producto.php';

    class Factura{
        private $cliente;
        private $productos = [];

        public function __construct(Cliente $cliente){
            $this->cliente = $cliente;
        }

        public function agregarProducto(Producto $producto, $cantidad){
            $this->productos[] = [
                'producto' => $producto,
                'cantidad' => $cantidad
            ];
        }

        public function getCliente() {
            return $this->cliente;
        }
    
        public function getProductos() {
            return $this->productos;
        }

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
                echo "Nombre: {$producto['producto']->getNombre()} Precio: {$producto['producto']->getPrecio()} Cantidad: {$producto['cantidad']} <br>";
            }
            echo "Total: {$this->calcularTotal()} <br>";
        }

    }

    /*$cliente1 = new Cliente("Juan", "Pérez", "12345678", "555-1234");

    $producto1 = new Producto("Producto A", 100);
    $producto2 = new Producto("Producto B", 150);

    $factura1 = new Factura($cliente1);
    $factura1->agregarProducto($producto1, 2);
    $factura1->agregarProducto($producto2, 3);
    $factura1->mostrarFactura();*/
