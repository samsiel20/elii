<?php include '../templates/header.php'; ?>
<h2>Subir Archivo CSV</h2>
<form action="upload.php" method="post" enctype="multipart/form-data">
    <input type="file" name="file" accept=".csv" required>
    <button type="submit">Subir</button>
</form>
<?php include '../templates/footer.php'; ?>