<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Biblioteca Digital</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE BIBLIOTECA DIGITAL</h1>
    <nav>
        <a href="index.php">[ Inicio ]</a>
        <a href="libro/listar.php">[ Libros ]</a>
        <a href="autor/listar.php">[ Autores ]</a>
        <a href="categoria/listar.php">[ Categorías ]</a>
        <a href="usuario/listar.php">[ Usuarios ]</a>
        <a href="descarga/listar.php">[ Descargas ]</a>
        <a href="consultas/libros_por_categoria.php">[ Consultas ]</a>
    </nav>
</header>

<main>

    <h2>Menú principal</h2>

    <h3>Altas</h3>
    <ul>
        <li><a href="libro/alta.php">Registrar libro digital</a></li>
        <li><a href="autor/alta.php">Registrar autor</a></li>
        <li><a href="categoria/alta.php">Registrar categoría</a></li>
        <li><a href="usuario/alta.php">Registrar usuario</a></li>
        <li><a href="descarga/alta.php">Registrar descarga</a></li>
        <li><a href="libro/asociar.php">Asociar autores a libro</a></li>
    </ul>

    <h3>Listados y operaciones</h3>
    <ul>
        <li><a href="libro/listar.php">Listar y modificar libros</a></li>
        <li><a href="autor/listar.php">Listar y modificar autores</a></li>
        <li><a href="categoria/listar.php">Listar y modificar categorías</a></li>
        <li><a href="usuario/listar.php">Listar y modificar usuarios</a></li>
        <li><a href="descarga/listar.php">Listar y eliminar descargas</a></li>
    </ul>

    <h3>Consultas</h3>
    <ul>
        <li><a href="consultas/libros_por_categoria.php">Libros por categoría</a></li>
        <li><a href="consultas/descargas_por_libro.php">Descargas por libro</a></li>
        <li><a href="consultas/descargas_por_usuario.php">Descargas por usuario</a></li>
    </ul>

</main>

<footer>
    <p>Trabajo Práctico — Sistema de Biblioteca Digital</p>
</footer>

</body>
</html>