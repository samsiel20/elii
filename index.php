<?php
require '../config/config.php';
require '../src/Database.php';
require '../src/SchoolController.php';

$controller = new SchoolController();

// Manejo de operaciones CRUD
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        // Crear escuela
        $data = [
            'nombre' => $_POST['nombre'],
            'nivel' => $_POST['nivel'],
            'turno' => $_POST['turno'],
            'sostenimiento' => $_POST['sostenimiento'],
            'domicilio' => $_POST['domicilio'],
            'ubicacion' => $_POST['ubicacion'],
            'colonia' => $_POST['colonia'],
            'alcaldia' => $_POST['alcaldia'],
            'latitud' => $_POST['latitud'],
            'longitud' => $_POST['longitud']
        ];
        $controller->createSchool($data);
    } elseif (isset($_POST['update'])) {
        // Actualizar escuela
        $data = [
            'id' => $_POST['id'],
            'nombre' => $_POST['nombre'],
            'nivel' => $_POST['nivel'],
            'turno' => $_POST['turno'],
            'sostenimiento' => $_POST['sostenimiento'],
            'domicilio' => $_POST['domicilio'],
            'ubicacion' => $_POST['ubicacion'],
            'colonia' => $_POST['colonia'],
            'alcaldia' => $_POST['alcaldia'],
            'latitud' => $_POST['latitud'],
            'longitud' => $_POST['longitud']
        ];
        $controller->updateSchool($data);
    } elseif (isset($_POST['delete'])) {
        // Eliminar escuela
        $controller->deleteSchool($_POST['id']);
    }
    header("Location: index.php");
    exit();
}

// Obtener todas las escuelas para listar
$schools = $controller->getAllSchools();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Escuelas</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
</head>
<body>
<header>
    <h1>Gestión de Escuelas</h1>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="index.php?action=create">Crear Escuela</a></li>
            <li><a href="dashboard.html">Dashboard</a></li>
        </ul>
    </nav>
</header>
<main>

<?php if (isset($_GET['action']) && $_GET['action'] == 'create'): ?>
    <h2>Crear Nueva Escuela</h2>
    <form action="index.php" method="post">
        <input type="hidden" name="create">
        <input type="text" name="nombre" placeholder="Nombre" required><br>
        <input type="text" name="nivel" placeholder="Nivel" required><br>
        <input type="text" name="turno" placeholder="Turno" required><br>
        <input type="text" name="sostenimiento" placeholder="Sostenimiento" required><br>
        <input type="text" name="domicilio" placeholder="Domicilio" required><br>
        <input type="text" name="ubicacion" placeholder="Ubicación" required><br>
        <input type="text" name="colonia" placeholder="Colonia" required><br>
        <input type="text" name="alcaldia" placeholder="Alcaldía" required><br>
        <input type="text" name="latitud" placeholder="Latitud" required><br>
        <input type="text" name="longitud" placeholder="Longitud" required><br>
        <button type="submit">Crear</button>
    </form>
<?php elseif (isset($_GET['action']) && $_GET['action'] == 'update' && isset($_GET['id'])): 
    $school = $controller->getSchoolById($_GET['id']);
?>
    <h2>Actualizar Escuela</h2>
    <form action="index.php" method="post">
        <input type="hidden" name="update">
        <input type="hidden" name="id" value="<?php echo $school['id']; ?>">
        <input type="text" name="nombre" value="<?php echo $school['nombre']; ?>" required><br>
        <input type="text" name="nivel" value="<?php echo $school['nivel']; ?>" required><br>
        <input type="text" name="turno" value="<?php echo $school['turno']; ?>" required><br>
        <input type="text" name="sostenimiento" value="<?php echo $school['sostenimiento']; ?>" required><br>
        <input type="text" name="domicilio" value="<?php echo $school['domicilio']; ?>" required><br>
        <input type="text" name="ubicacion" value="<?php echo $school['ubicacion']; ?>" required><br>
        <input type="text" name="colonia" value="<?php echo $school['colonia']; ?>" required><br>
        <input type="text" name="alcaldia" value="<?php echo $school['alcaldia']; ?>" required><br>
        <input type="text" name="latitud" value="<?php echo $school['latitud']; ?>" required><br>
        <input type="text" name="longitud" value="<?php echo $school['longitud']; ?>" required><br>
        <button type="submit">Actualizar</button>
    </form>
<?php elseif (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])): 
    $school = $controller->getSchoolById($_GET['id']);
?>
    <h2>Eliminar Escuela</h2>
    <p>¿Estás seguro de que deseas eliminar la escuela "<?php echo $school['nombre']; ?>"?</p>
    <form action="index.php" method="post">
        <input type="hidden" name="delete">
        <input type="hidden" name="id" value="<?php echo $school['id']; ?>">
        <button type="submit">Eliminar</button>
    </form>
<?php else: ?>
    <h2>Listado de Escuelas</h2>
    <a href="index.php?action=create">Crear Nueva Escuela</a>
    <table>
        <tr>
            <th>Nombre</th>
            <th>Nivel</th>
            <th>Turno</th>
            <th>Sostenimiento</th>
            <th>Domicilio</th>
            <th>Ubicación</th>
            <th>Colonia</th>
            <th>Alcaldía</th>
            <th>Latitud</th>
            <th>Longitud</th>
            <th>Acciones</th>
        </tr>
        <?php foreach($schools as $school): ?>
        <tr>
            <td><?php echo $school['nombre']; ?></td>
            <td><?php echo $school['nivel']; ?></td>
            <td><?php echo $school['turno']; ?></td>
            <td><?php echo $school['sostenimiento']; ?></td>
            <td><?php echo $school['domicilio']; ?></td>
            <td><?php echo $school['ubicacion']; ?></td>
            <td><?php echo $school['colonia']; ?></td>
            <td><?php echo $school['alcaldia']; ?></td>
            <td><?php echo $school['latitud']; ?></td>
            <td><?php echo $school['longitud']; ?></td>
            <td>
                <a href="index.php?action=update&id=<?php echo $school['id']; ?>">Editar</a>
                <a href="index.php?action=delete&id=<?php echo $school['id']; ?>">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

</main>
<footer>
    <p>&copy; 2024 Gestión de Escuelas</p>
</footer>
</body>
</html>