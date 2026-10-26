<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Publicaciones — Revista Académica</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE PUBLICACIONES — REVISTA ACADÉMICA</h1>
    <nav>
        <a href="index.php">[ Inicio ]</a>
        <a href="articulo/listar.php">[ Artículos ]</a>
        <a href="autor/listar.php">[ Autores ]</a>
        <a href="evaluador/listar.php">[ Evaluadores ]</a>
        <a href="seccion/listar.php">[ Secciones ]</a>
        <a href="evaluacion/listar.php">[ Evaluaciones ]</a>
        <a href="consultas/articulos_por_autor.php">[ Consultas ]</a>
    </nav>
</header>

<main>

    <h2>Menú principal</h2>

    <h3>Altas</h3>
    <ul>
        <li><a href="articulo/alta.php">Registrar artículo</a></li>
        <li><a href="autor/alta.php">Registrar autor</a></li>
        <li><a href="evaluador/alta.php">Registrar evaluador</a></li>
        <li><a href="seccion/alta.php">Registrar sección</a></li>
        <li><a href="evaluacion/alta.php">Registrar evaluación</a></li>
    </ul>

    <h3>Asociaciones</h3>
    <ul>
        <li><a href="articulo/asociar_autor.php">Asociar autores a artículos</a></li>
        <li><a href="articulo/asociar_evaluador.php">Asociar evaluadores a artículos</a></li>
    </ul>

    <h3>Listados y operaciones</h3>
    <ul>
        <li><a href="articulo/listar.php">Listar artículos</a></li>
        <li><a href="articulo/cambiar_estado.php">Modificar estado de artículos</a></li>
        <li><a href="autor/listar.php">Listar y modificar autores</a></li>
        <li><a href="evaluador/listar.php">Listar y modificar evaluadores</a></li>
        <li><a href="seccion/listar.php">Listar y eliminar secciones</a></li>
        <li><a href="evaluacion/listar.php">Listar evaluaciones</a></li>
    </ul>

    <h3>Consultas</h3>
    <ul>
        <li><a href="consultas/articulos_por_autor.php">Artículos por autor</a></li>
        <li><a href="consultas/articulos_por_estado.php">Artículos por estado</a></li>
    </ul>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Publicaciones de una Revista Académica</p>
</footer>

</body>
</html>