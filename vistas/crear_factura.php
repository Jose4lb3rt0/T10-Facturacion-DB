<?php

    require_once '../clases/cliente.php';
    require_once '../clases/producto.php';
    require_once '../clases/factura.php';
    require_once '../db/ProductoDB.php';
    require_once '../db/ClienteDB.php';
    require_once '../db/FacturaDB.php';
    require 'layout.php';

    $facturaDB = new FacturaDB($conexion);
    $productoDB = new ProductoDB($conexion);
    $clienteDB = new ClienteDB($conexion);

    $clientes = $clienteDB->obtenerClientes();
    $productos = $productoDB->obtenerProductos();

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        
        if(isset($_POST['eliminar'])){
            $facturaDB->eliminarFactura($_POST['eliminar']);
        } else if(isset($_POST['cliente']) && isset($_POST['items'])){
            $cliente_id = $_POST['cliente'];
            $items = $_POST['items'];

            $total = 0;
            foreach($items as $item){
                $producto_id = $item['producto'];
                $cantidad = $item['cantidad'];

                $producto = $productoDB->obtenerProducto($producto_id);
                $total += $producto->getPrecio() * $cantidad;
            }
            
            $factura_id = $facturaDB->crearFactura($cliente_id, $total);
            
            foreach ($items as $item){
                $producto_id = $item['producto'];
                $cantidad = $item['cantidad'];
                $facturaDB->agregarProductoAFactura($factura_id, $producto_id, $cantidad);
            }
        }
    }

    $facturas = $facturaDB->obtenerFacturas();

    ?>

    <body>
        <div class="flex p-4 justify-center gap-5">
            <div class="bg-white p-8 rounded-lg shadow-lg max-w-2xl">

                <div class="flex items-center gap-1 text-2xl font-bold text-gray-700 mb-5 justify-center">
                    <i class="fa-solid fa-receipt"></i>
                    <h2 class=" text-center">Crear Factura</h2>
                </div>

                <form method="POST" action="">
                    <table class="bg-white shadow-md rounded-lg max-w-4xl w-full mb-4">
                        <thead>
                            <tr class="bg-blue-500 text-white">
                                <th colspan="4" class="rounded-t-lg py-2 px-4 text-center">Seleccionar Cliente</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 px-4" colspan="4">
                                    <select name="cliente" class="border border-gray-300 rounded-lg p-2 w-full" required>
                                        <option value="">Seleccionar Cliente</option>
                                        <?php foreach ($clientes as $cliente): ?>
                                            <option value="<?= $cliente['id']; ?>">
                                                <?php echo $cliente['nombre'] . ' ' . $cliente['apellido'] . ' - ' . $cliente['dni'] . ' - ' . $cliente['telefono']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="bg-white shadow-md rounded-lg max-w-4xl w-full mb-4">
                        <thead>
                            <tr class="bg-blue-500 text-white text-left">
                                <th class="rounded-tl-lg py-2 px-4">Producto</th>
                                <th class="py-2 px-4 text-center">Precio</th>
                                <th class="py-2 px-4 text-center">Cantidad</th>
                                <th class="rounded-tr-lg py-2 px-4 text-center">Llevar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productos as $producto_id => $producto): ?>
                                <tr class="border-b">
                                    <td class="py-2 px-4"><?php echo $producto->getNombre(); ?></td>
                                    <td class="py-2 px-4 text-center"><?php echo 'S/ ' . number_format($producto->getPrecio(), 2); ?></td>
                                    <td class="py-2 px-4 text-center">
                                        <!--Input de numero cantidad-->
                                        <input 
                                            type="number" 
                                            class="border rounded-lg p-2 text-center w-20" 
                                            id="cantidadInput" 
                                            name="items[<?= $producto_id ?>][cantidad]" 
                                            min="1" 
                                            value="1" 
                                            onchange="calcularTotal()"
                                        >
                                    </td>
                                    <td class="py-2 px-4 flex justify-center">
                                        <!--Checkbox-->
                                        <input 
                                            type="checkbox" 
                                            name="items[<?= $producto_id ?>][producto]" 
                                            value="<?= $producto_id; ?>" 
                                            data-precio="<?= $producto->getPrecio(); ?>"  
                                            onchange="calcularTotal()"
                                        >
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <strong class="flex justify-center">Total: S/ <span id="total">0.00</span></strong>

                    <div class="flex justify-center MT-5">
                        <button type="submit" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-300">
                            Agregar factura
                        </button>
                    </div>
                </form>

                <table class="bg-white shadow-md rounded-lg max-w-4xl mt-4">
                    <thead>
                        <tr class="bg-gray-400 text-gray-800 text-left">
                            <th class="rounded-tl-lg py-2 px-4">Cliente</th>
                            <th class="py-2 px-4 text-center">Productos</th>
                            <th class="py-2 px-4 text-center">Total</th>
                            <th class="rounded-tr-lg py-2 px-4 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($facturas)): ?>
                            <?php foreach ($facturas as $factura): ?>
                                <tr class="border-b bg-gray-300 text-gray-600 font-bold h-32">
                                    <td class="py-2 px-4">
                                        <?php
                                            $cliente = $clienteDB->obtenerCliente($factura['cliente_id']); 
                                            echo $cliente['nombre'] . ' ' . $cliente['apellido'] . ' - ' . $cliente['dni'] . ' - ' . $cliente['telefono']; 
                                        ?>
                                    </td>
                                    <td class="py-2 px-4">
                                        <?php $productos = $facturaDB->obtenerProductosDeFactura($factura['id']); ?>
                                        <?php foreach ($productos as $item): ?>
                                            <?php $producto = $productoDB->obtenerProducto($item['producto_id']); ?>
                                            <?php echo '- ' . $producto->getNombre(); ?> (x <?php echo $item['cantidad']; ?>)<br>
                                        <?php endforeach; ?>
                                    </td>
                                    <td class="py-2 px-4">S/ <?= number_format($factura['total'], 2); ?></td>
                                    <td class="py-2 px-4 text-center">
                                        <form action="" method="POST">
                                            <input type="hidden" name="eliminar" value="<?= $factura['id']; ?>">
                                            <button type="submit" class="bg-gray-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-red-600 focus:ring-2 focus:ring-red-500 focus:outline-none transition-all duration-300">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="py-2 px-4 text-center">No hay facturas registradas.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>
        </div>

        <script>
            function calcularTotal() {
                let total = 0;
                const checkboxes = document.querySelectorAll('input[type="checkbox"]');

                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        const cantidadInput = checkbox.closest('tr').querySelector('input[type="number"]');
                        const cantidad = parseInt(cantidadInput.value);
                        total += parseFloat(checkbox.getAttribute('data-precio')) * cantidad;
                    }
                });
                document.getElementById('total').textContent = total.toFixed(2);
            }
        </script>
    </body>