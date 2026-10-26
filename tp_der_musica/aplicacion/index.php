<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Escuela de Música</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE ESCUELA DE MÚSICA</h1>
    <nav>
        <a href="index.php">[ Inicio ]</a>
        <a href="curso/listar.php">[ Cursos ]</a>
        <a href="docente/listar.php">[ Docentes ]</a>
        <a href="estudiante/listar.php">[ Estudiantes ]</a>
        <a href="instrumento/listar.php">[ Instrumentos ]</a>
        <a href="inscripcion/listar.php">[ Inscripciones ]</a>
        <a href="consultas/estudiantes_por_curso.php">[ Consultas ]</a>
    </nav>
</header>

<main>

    <h2>Menú principal</h2>

    <h3>Altas</h3>
    <ul>
        <li><a href="estudiante/alta.php">Registrar estudiante</a></li>
        <li><a href="docente/alta.php">Registrar docente</a></li>
        <li><a href="instrumento/alta.php">Registrar instrumento</a></li>
        <li><a href="curso/alta.php">Registrar curso</a></li>
        <li><a href="inscripcion/alta.php">Realizar inscripción</a></li>
    </ul>

    <h3>Listados y operaciones</h3>
    <ul>
        <li><a href="estudiante/listar.php">Listar y modificar estudiantes</a></li>
        <li><a href="docente/listar.php">Listar y modificar docentes</a></li>
        <li><a href="instrumento/listar.php">Listar y eliminar instrumentos</a></li>
        <li><a href="curso/listar.php">Listar y modificar cursos</a></li>
        <li><a href="inscripcion/listar.php">Listar inscripciones</a></li>
    </ul>

    <h3>Consultas</h3>
    <ul>
        <li><a href="consultas/estudiantes_por_curso.php">Estudiantes por curso</a></li>
        <li><a href="consultas/docentes_por_instrumento.php">Docentes por instrumento</a></li>
        <li><a href="consultas/horarios_clases.php">Horarios de clases</a></li>
    </ul>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Escuela de Música</p>
</footer>

</body>
</html>