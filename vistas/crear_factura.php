<?php

require_once '../clases/cliente.php';
require_once '../clases/producto.php';
require_once '../clases/factura.php';
require 'layout.php';

$clientes = isset($_SESSION['clientes']) ? $_SESSION['clientes'] : [];
$productos = isset($_SESSION['productos']) ? $_SESSION['productos'] : [];
$facturas = isset($_SESSION['facturas']) ? $_SESSION['facturas'] : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['eliminar'])) {
    $cliente_index = $_POST['cliente'];
    $items = $_POST['items'];

    if (isset($clientes[$cliente_index])) {
        $cliente = $clientes[$cliente_index];
        $factura = new Factura($cliente);

        foreach ($items as $item) {
            if (isset($item['producto'])) {
                $producto_index = $item['producto'];
                $cantidad = $item['cantidad'];
                if (isset($productos[$producto_index])) {
                    $producto = $productos[$producto_index];
                    $factura->agregarProducto($producto, $cantidad);
                }
            }
        }

        $_SESSION['facturas'][] = $factura;
        header('Location: ' . $_SERVER['PHP_SELF']); //Recargar para que me salga el último registro
    }
}

if (isset($_POST['eliminar'])){
    $index = $_POST['index'];
    if (isset($facturas[$index])){
        unset($facturas[$index]);
        $_SESSION['facturas'] = array_values($facturas);
    }
}

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
                                    <?php foreach ($clientes as $index => $cliente): ?>
                                        <option value="<?= $index; ?>">
                                            <?php echo $cliente->getNombre() . ' ' . $cliente->getApellido() . ' - ' . $cliente->getDni(); ?></option>
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
                        <?php foreach ($productos as $index => $producto): ?>
                            <tr class="border-b">
                                <td class="py-2 px-4"><?php echo $producto->getNombre(); ?></td>
                                <td class="py-2 px-4 text-center"><?php echo 'S/ ' . number_format($producto->getPrecio(), 2); ?></td>
                                <td class="py-2 px-4 text-center">
                                    <input type="number" class="border rounded-lg p-2 text-center w-20" id="cantidadInput" name="items[<?= $index ?>][cantidad]" min="1" value="1" onchange="calcularTotal()">
                                </td>
                                <td class="py-2 px-4 flex justify-center">
                                    <input type="checkbox" name="items[<?= $index ?>][producto]" value="<?= $index ?>" data-precio="<?php echo $producto->getPrecio(); ?>" onchange="calcularTotal()">
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
                                    <?php echo 
                                        $factura->getCliente()->getNombre() . ' ' . 
                                        $factura->getCliente()->getApellido() . ' ' .  
                                        $factura->getCliente()->getDNI() . ' ' .  
                                        $factura->getCliente()->getTelefono(); 
                                    ?>
                                </td>
                                <td class="py-2 px-4">
                                    <?php foreach ($factura->getProductos() as $item): ?>
                                        <?php echo '- ' . $item['producto']->getNombre(); ?> (x <?php echo $item['cantidad']; ?>)<br>
                                    <?php endforeach; ?>
                                </td>
                                <td class="py-2 px-4">S/ <?= number_format($factura->calcularTotal(), 2); ?></td>
                                <td class="py-2 px-4 text-center">
                                    <form action="" method="POST">
                                        <input type="hidden" name="index" value="<?= array_search($factura, $facturas); ?>">
                                        <button type="submit" name="eliminar" class="bg-gray-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-red-600 focus:ring-2 focus:ring-red-500 focus:outline-none transition-all duration-300">
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