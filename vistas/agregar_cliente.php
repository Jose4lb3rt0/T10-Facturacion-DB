<?php
    require_once '../clases/cliente.php';
    require_once '../db/ClienteDB.php';
    require_once '../clases/producto.php';
    require_once '../clases/factura.php'; 
    require 'layout.php';

    $clienteDB = new ClienteDB($conexion);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (isset($_POST['eliminar'])) {
            $clienteDB->eliminarCliente($_POST['eliminar']);
        } else if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['dni']) && isset($_POST['telefono'])) {
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $dni = $_POST['dni'];
            $telefono = $_POST['telefono'];
        
            $cliente = new Cliente($nombre, $apellido, $dni, $telefono);
            $clienteDB->agregarCliente($cliente);
        }
    }

    $clientes = $clienteDB->obtenerClientes();
?>

<body>

        <div class="flex p-4 justify-center gap-5">
            <div class="bg-white p-8 rounded-lg shadow-lg max-w-xl">
                <form method="POST" action="">
                    <div class="flex items-center gap-1 text-2xl font-bold text-gray-700 mb-5 justify-center">
                        <i class="fa-solid fa-user"></i>
                        <h2 class=" text-center">Agregar Cliente</h2>
                    </div>
                    <div class="mb-4">
                        <label for="nombre" class="block text-gray-600 font-semibold mb-2">Nombre del Cliente:</label>
                        <input type="text" id="nombre" name="nombre" class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Ingresa el nombre" required>
                    </div>
                    <div class="mb-4">
                        <label for="apellido" class="block text-gray-600 font-semibold mb-2">Apellido del Cliente:</label>
                        <input type="text" id="apellido" name="apellido" class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Ingresa el apellido" required>
                    </div>
                    <div class="mb-4">
                        <label for="dni" class="block text-gray-600 font-semibold mb-2">DNI:</label>
                        <input type="text" id="dni" name="dni" class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Ingresa el DNI" required>
                    </div>
                    <div class="mb-4">
                        <label for="telefono" class="block text-gray-600 font-semibold mb-2">Teléfono:</label>
                        <input type="text" id="telefono" name="telefono" class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Ingresa el telefono" required>
                    </div>
                    <div class="flex justify-center mt-5">
                        <button type="submit" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-300">
                            Agregar cliente
                        </button>
                    </div>
                </form>
                
                <table class="bg-white shadow-md rounded-lg max-w-xl w-full mb-4">
                    <thead>
                        <tr class="bg-blue-500 text-white text-left">
                            <th class="rounded-tl-lg py-2 px-4 text-center">Nombre</th>
                            <th class="py-2 px-4 text-center">DNI</th>
                            <th class="py-2 px-4 text-center">Teléfono</th>
                            <th class="rounded-tr-lg py-2 px-4 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clientes as $cliente): ?>
                            <tr class="border-b">
                                <td class="py-2 px-4 text-center">
                                    <?php echo $cliente['nombre'] . ' ' . $cliente['apellido']; ?>
                                </td>
                                <td class="py-2 px-4 text-center">
                                    <?php echo $cliente['dni']; ?>
                                </td>
                                <td class="py-2 px-4 text-center">
                                    <?php echo $cliente['telefono']; ?>
                                </td>
                                <td class="py-2 px-4 text-center flex items-center justify-center">
                                    <form method="POST" action="" >
                                        <input type="hidden" name="eliminar" value="<?= $cliente['id']; ?>">
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