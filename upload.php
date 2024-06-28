<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    require '../config/config.php';

    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $file = $_FILES['file']['tmp_name'];
    $handle = fopen($file, "r");

    if ($handle !== FALSE) {
        // Ignorar la primera línea (encabezados)
        fgetcsv($handle, 1000, ",");
        
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $nombre = $conn->real_escape_string($data[0]);
            $nivel = $conn->real_escape_string($data[1]);
            $turno = $conn->real_escape_string($data[2]);
            $sostenimiento = $conn->real_escape_string($data[3]);
            $domicilio = $conn->real_escape_string($data[4]);
            $ubicacion = $conn->real_escape_string($data[5]);
            $colonia = $conn->real_escape_string($data[6]);
            $alcaldia = $conn->real_escape_string($data[7]);
            $latitud = $conn->real_escape_string($data[8]);
            $longitud = $conn->real_escape_string($data[9]);

            $sql = "INSERT INTO escuelas_privadas (nombre, nivel, turno, sostenimiento, domicilio, ubicacion, colonia, alcaldia, latitud, longitud)
                    VALUES ('$nombre', '$nivel', '$turno', '$sostenimiento', '$domicilio', '$ubicacion', '$colonia', '$alcaldia', '$latitud', '$longitud')";

            if (!$conn->query($sql)) {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        fclose($handle);
        echo "Datos cargados exitosamente.";
    } else {
        echo "Error al abrir el archivo.";
    }

    $conn->close();
} else {
    echo "Por favor, suba un archivo CSV.";
}
?>