<?php
class SchoolController {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->getConnection();
    }

    public function getAllSchools() {
        $query = "SELECT * FROM escuelas_privadas";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getSchoolById($id) {
        $query = "SELECT * FROM escuelas_privadas WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function createSchool($data) {
        $query = "INSERT INTO escuelas_privadas (nombre, nivel, turno, sostenimiento, domicilio, ubicacion, colonia, alcaldia, latitud, longitud)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssssssdd", $data['nombre'], $data['nivel'], $data['turno'], $data['sostenimiento'], $data['domicilio'], $data['ubicacion'], $data['colonia'], $data['alcaldia'], $data['latitud'], $data['longitud']);
        return $stmt->execute();
    }

    public function updateSchool($data) {
        $query = "UPDATE escuelas_privadas SET nombre=?, nivel=?, turno=?, sostenimiento=?, domicilio=?, ubicacion=?, colonia=?, alcaldia=?, latitud=?, longitud=? WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssssssddi", $data['nombre'], $data['nivel'], $data['turno'], $data['sostenimiento'], $data['domicilio'], $data['ubicacion'], $data['colonia'], $data['alcaldia'], $data['latitud'], $data['longitud'], $data['id']);
        return $stmt->execute();
    }

    public function deleteSchool($id) {
        $query = "DELETE FROM escuelas_privadas WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>