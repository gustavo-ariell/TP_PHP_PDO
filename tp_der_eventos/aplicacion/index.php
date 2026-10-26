<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Eventos Académicos</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE EVENTOS ACADÉMICOS</h1>
    <nav>
        <a href="index.php">[ Inicio ]</a>
        <a href="evento/listar.php">[ Eventos ]</a>
        <a href="expositor/listar.php">[ Expositores ]</a>
        <a href="asistente/listar.php">[ Asistentes ]</a>
        <a href="tipo_evento/listar.php">[ Tipos ]</a>
        <a href="inscripcion/listar.php">[ Inscripciones ]</a>
        <a href="consultas/asistentes_por_evento.php">[ Consultas ]</a>
    </nav>
</header>

<main>

    <h2>Menú principal</h2>

    <h3>Altas</h3>
    <ul>
        <li><a href="evento/alta.php">Registrar evento</a></li>
        <li><a href="expositor/alta.php">Registrar expositor</a></li>
        <li><a href="asistente/alta.php">Registrar asistente</a></li>
        <li><a href="tipo_evento/alta.php">Registrar tipo de evento</a></li>
        <li><a href="inscripcion/alta.php">Realizar inscripción</a></li>
        <li><a href="evento/asociar.php">Asociar expositores con eventos</a></li>
    </ul>

    <h3>Listados y operaciones</h3>
    <ul>
        <li><a href="evento/listar.php">Listar y modificar eventos</a></li>
        <li><a href="expositor/listar.php">Listar y modificar expositores</a></li>
        <li><a href="asistente/listar.php">Listar y modificar asistentes</a></li>
        <li><a href="tipo_evento/listar.php">Listar y modificar tipos</a></li>
        <li><a href="inscripcion/listar.php">Listar y eliminar inscripciones</a></li>
    </ul>

    <h3>Consultas</h3>
    <ul>
        <li><a href="consultas/asistentes_por_evento.php">Asistentes por evento</a></li>
        <li><a href="consultas/expositores_por_evento.php">Expositores por evento</a></li>
        <li><a href="consultas/cantidad_inscritos.php">Cantidad de inscritos por evento</a></li>
    </ul>

</main>

<footer>
    <p>Trabajo Práctico — Sistema de Gestión de Eventos Académicos</p>
</footer>

</body>
</html>