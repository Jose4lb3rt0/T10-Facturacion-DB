<?php
    require_once '../clases/cliente.php'; 
    require_once '../clases/producto.php';
    require_once '../db/ProductoDB.php';
    require_once '../clases/factura.php'; 
    require 'layout.php';

    $productoDB = new ProductoDB($conexion);

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){

        if (isset($_POST['eliminar'])){
            $productoDB->eliminarProducto($_POST['eliminar']);
        } else if (isset($_POST['nombre']) && isset($_POST['precio'])){
            $nombre = $_POST['nombre'];
            $precio = $_POST['precio'];

            $producto = new Producto($nombre, $precio);
            $productoDB->agregarProducto($producto);
        }
    }
    
    $productos = $productoDB->obtenerProductos();

?>

<body>
        <div class="flex p-4 justify-center gap-5">
            <div class="bg-white p-8 rounded-lg shadow-lg w-1/2 max-w-xl">
                <form method="POST" action="">
                    <div class="flex items-center gap-1 text-2xl font-bold text-gray-700 mb-5 justify-center">
                        <i class="fa-solid fa-burger"></i>
                        <h2 class=" text-center">Agregar Producto</h2>
                    </div>
                    <div class="mb-4">
                        <label for="nombre" class="block text-gray-600 font-semibold mb-2">Nombre del producto:</label>
                        <input type="text" id="nombre" name="nombre" class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Ingresa el nombre" required>
                    </div>
                    <div class="mb-4">
                        <label for="precio" class="block text-gray-600 font-semibold mb-2">Precio del producto:</label>
                        <input type="number" id="precio" name="precio" class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Ingresa el precio" required>
                    </div>
                    <div class="flex justify-center mt-5">
                        <button type="submit" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-300">
                            Agregar producto
                        </button>
                    </div>
                </form>
                
                <table class="bg-white shadow-md rounded-lg max-w-xl w-full mb-4">
                    <thead>
                        <tr class="bg-blue-500 text-white text-left">
                            <th class="rounded-tl-lg py-2 px-4 text-center">Nombre</th>
                            <th class="py-2 px-4 text-center">Precio</th>
                            <th class="rounded-tr-lg py-2 px-4 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $producto): ?>
                            <tr class="border-b">
                                <td class="py-2 px-4 text-center">
                                    <?php echo $producto['nombre']; ?>
                                </td>
                                <td class="py-2 px-4 text-center">
                                    <?php echo 'S/ ' . $producto['precio']; ?>
                                </td>
                                <td class="py-2 px-4 text-center flex items-center justify-center">
                                    <form method="POST" action="" >
                                        <input type="hidden" name="eliminar" value="<?= $producto['id']; ?>">
                                        <button type="submit" class="bg-red-500 text-white font-semibold p-3 rounded-lg hover:bg-red-600 focus:outline-none">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>

</body>