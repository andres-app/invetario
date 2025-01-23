<?php
$host = 'localhost';
$dbname = 'inventory';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}

$codigo_sbn = $_POST['codigo_sbn'] ?? '';
$bien = $_POST['bien'] ?? null;
$marca = $_POST['marca'] ?? null;
$modelo = $_POST['modelo'] ?? null;
$usuario = $_POST['usuario'] ?? null;

if (empty($codigo_sbn)) {
    die("Error: El código patrimonial es obligatorio.");
}

$updateFields = [];
$params = [':codigo_sbn' => $codigo_sbn];

if ($bien !== null) $updateFields[] = "bien = :bien";
if ($marca !== null) $updateFields[] = "marca = :marca";
if ($modelo !== null) $updateFields[] = "modelo = :modelo";
if ($usuario !== null) $updateFields[] = "usuario = :usuario";

$params += [
    ':bien' => $bien,
    ':marca' => $marca,
    ':modelo' => $modelo,
    ':usuario' => $usuario,
];

if (!empty($updateFields)) {
    $sql = "UPDATE activos SET " . implode(', ', $updateFields) . " WHERE codigo_sbn = :codigo_sbn";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute($params);
        echo "Datos actualizados correctamente.";
    } catch (PDOException $e) {
        die("Error al actualizar los datos: " . $e->getMessage());
    }
} else {
    die("No se proporcionaron datos para actualizar.");
}
?>
