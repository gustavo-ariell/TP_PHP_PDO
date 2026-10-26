<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Inscripción a Olimpiadas Escolares</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE INSCRIPCIÓN A OLIMPIADAS ESCOLARES</h1>
    <nav>
        <a href="index.php">[ Inicio ]</a>
        <a href="estudiante/listar.php">[ Estudiantes ]</a>
        <a href="disciplina/listar.php">[ Disciplinas ]</a>
        <a href="inscripcion/listar.php">[ Inscripciones ]</a>
        <a href="consultas/estudiantes_inscritos.php">[ Consultas ]</a>
    </nav>
</header>

<main>

    <h2>Menú principal</h2>

    <h3>Altas</h3>
    <ul>
        <li><a href="estudiante/alta.php">Registrar estudiante</a></li>
        <li><a href="disciplina/alta.php">Registrar disciplina</a></li>
        <li><a href="inscripcion/alta.php">Realizar inscripción</a></li>
    </ul>

    <h3>Listados y operaciones</h3>
    <ul>
        <li><a href="estudiante/listar.php">Listar y modificar estudiantes</a></li>
        <li><a href="disciplina/listar.php">Listar y modificar disciplinas</a></li>
        <li><a href="inscripcion/listar.php">Listar inscripciones</a></li>
        <li><a href="inscripcion/editar.php">Modificar estado de inscripción</a></li>
    </ul>

    <h3>Consultas</h3>
    <ul>
        <li><a href="consultas/estudiantes_inscritos.php">Estudiantes inscritos</a></li>
        <li><a href="consultas/participantes_por_disciplina.php">Participantes por deporte</a></li>
        <li><a href="consultas/participantes_por_curso.php">Participantes por curso</a></li>
        <li><a href="consultas/participantes_por_provincia.php">Participantes por provincia</a></li>
    </ul>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Inscripción a Olimpiadas Escolares</p>
</footer>

</body>
</html>