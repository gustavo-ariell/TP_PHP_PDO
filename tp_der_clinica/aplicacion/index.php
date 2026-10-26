<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Turnos Clínica</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TURNOS CLÍNICA</h1>
    <nav>
        <a href="index.php">[ Inicio ]</a>
        <a href="paciente/listar.php">[ Pacientes ]</a>
        <a href="medico/listar.php">[ Médicos ]</a>
        <a href="especialidad/listar.php">[ Especialidades ]</a>
        <a href="turno/listar.php">[ Turnos ]</a>
        <a href="consultas/turnos_por_medico.php">[ Consultas ]</a>
    </nav>
</header>

<main>

    <h2>Menú principal</h2>

    <h3>Altas</h3>
    <ul>
        <li><a href="paciente/alta.php">Registrar paciente</a></li>
        <li><a href="medico/alta.php">Registrar médico</a></li>
        <li><a href="especialidad/alta.php">Registrar especialidad</a></li>
        <li><a href="turno/alta.php">Solicitar turno</a></li>
    </ul>

    <h3>Listados y operaciones</h3>
    <ul>
        <li><a href="paciente/listar.php">Listar y modificar pacientes</a></li>
        <li><a href="medico/listar.php">Listar y modificar médicos</a></li>
        <li><a href="especialidad/listar.php">Listar y modificar especialidades</a></li>
        <li><a href="turno/listar.php">Listar turnos</a></li>
        <li><a href="turno/editar.php">Modificar estado de turnos</a></li>
    </ul>

    <h3>Consultas</h3>
    <ul>
        <li><a href="consultas/turnos_por_medico.php">Turnos por médico</a></li>
        <li><a href="consultas/turnos_por_paciente.php">Turnos por paciente</a></li>
        <li><a href="consultas/turnos_por_fecha.php">Turnos por fecha</a></li>
        <li><a href="consultas/turnos_por_especialidad.php">Turnos por especialidad</a></li>
    </ul>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Turnos en una Clínica</p>
</footer>

</body>
</html>