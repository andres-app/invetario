<?php
$host = 'localhost';
$dbname = 'inventory';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(['exito' => false, 'mensaje' => 'Error al conectar con la base de datos: ' . $e->getMessage()]));
}

$codigo_barras = trim($_GET['codigo_barras'] ?? '');

if ($codigo_barras) {
    $stmt = $pdo->prepare("SELECT * FROM activos WHERE codigo_sbn = :codigo");
    $stmt->bindParam(':codigo', $codigo_barras);
    $stmt->execute();
    $activo = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($activo) {
        echo json_encode(['exito' => true] + $activo);
    } else {
        echo json_encode(['exito' => false, 'mensaje' => 'Activo no encontrado.']);
    }
} else {
    echo json_encode(['exito' => false, 'mensaje' => 'Código patrimonial no proporcionado.']);
}
?>
