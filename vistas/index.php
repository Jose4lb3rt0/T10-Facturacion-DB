<?php
    require 'layout.php';
    require_once '../clases/cliente.php';
    require_once '../clases/producto.php';
    require_once '../clases/factura.php';

    if (!isset($_SESSION['clientes'])) {
        $_SESSION['clientes'] = [];
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['eliminar'])) {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $dni = $_POST['dni'];
        $telefono = $_POST['telefono'];
    
        $cliente = new Cliente($nombre, $apellido, $dni, $telefono);
        $_SESSION['clientes'][] = $cliente;
    }

    if (isset($_POST['eliminar'])) {
        $index = $_POST['index'];
        if (isset($_SESSION['clientes'][$index])) {
            unset($_SESSION['clientes'][$index]);
            $_SESSION['clientes'] = array_values($_SESSION['clientes']);
        }
    }
?>

<body>
    <div class="p-4">
        <h1 class="text-5xl font-bold flex justify-center text-gray-800">¡Bienvenido!</h1>
        <h1 class="text-xl font-semibold  flex justify-center text-gray-700 mb-4">Crea una nueva facturación</h1>
        <hr class="">
        </hr>
    </div>

    <div class="flex justify-center space-x-4">
        <a href="agregar_cliente.php" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-300">
            Agregar Clientes
        </a>
        <a href="agregar_producto.php" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-300">
            Agregar Productos
        </a>
        <a href="crear_factura.php" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-300">
            Crear Facturas
        </a>
    </div>
</body>