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
$campos = [
    'bien', 'nombre_equipo', 'procesador', 'sistema_operativo', 'memoria_ram',
    'capacidad_disco', 'area', 'usuario', 'nombres_completos', 'marca',
    'modelo', 'serie', 'estado'
];

if (empty($codigo_sbn)) {
    die("Error: El código patrimonial es obligatorio.");
}

$updateFields = [];
$params = [':codigo_sbn' => $codigo_sbn];

foreach ($campos as $campo) {
    if (!empty($_POST[$campo])) {
        $updateFields[] = "$campo = :$campo";
        $params[":$campo"] = $_POST[$campo];
    }
}

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
