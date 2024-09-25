<?php
session_start();

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura Electrónica</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    
</head>
<div class="w-full p-4 bg-blue-500 shadow-md flex justify-center gap-10 items-center">
    <a href="index.php" class="flex items-center space-x-2">
        <i class="fa-duotone fa-solid fa-money-bill text-green-400 text-2xl hover:text-green-800 transition duration-300"></i>
        <span class="text-xl font-semibold text-white hover:text-gray-200 transition duration-300">Inicio</span>
    </a>
    <a href="agregar_cliente.php" class="flex items-center space-x-2">
        <i class="fa-duotone fa-solid fa-user text-white text-2xl hover:text-gray-800 transition duration-300"></i>
        <span class="text-xl font-semibold text-white hover:text-gray-200 transition duration-300">Clientes</span>
    </a>
    <a href="agregar_producto.php" class="flex items-center space-x-2">
        <i class="fa-duotone fa-solid fa-box text-white text-2xl hover:text-gray-800 transition duration-300"></i>
        <span class="text-xl font-semibold text-white hover:text-gray-200 transition duration-300">Productos</span>
    </a>
    <a href="crear_factura.php" class="flex items-center space-x-2">
        <i class="fa-duotone fa-solid fa-file-invoice text-white text-2xl hover:text-gray-800 transition duration-300"></i>
        <span class="text-xl font-semibold text-white hover:text-gray-200 transition duration-300">Facturas</span>
    </a>
</div>

