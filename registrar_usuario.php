<?php
header('Content-Type: application/json');

// Conexión a la base de datos
$host = "127.0.0.1";
$user = "root";
$password = "Julio0205";
$dbname = "fraccionamiento_db";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Error de conexión: " . $conn->connect_error]);
    exit();
}

// Leer los datos JSON
$input = json_decode(file_get_contents('php://input'), true);

// Validar campos obligatorios
$campos = ['nombre', 'email', 'telefono', 'tipo_residente', 'calle', 'numero', 'manzana', 'lote'];
foreach ($campos as $campo) {
    if (empty($input[$campo])) {
        http_response_code(400);
        echo json_encode(["error" => "El campo '$campo' es obligatorio."]);
        exit();
    }
}

// Escapar datos
$nombre = $conn->real_escape_string($input['nombre']);
$email = $conn->real_escape_string($input['email']);
$telefono = $conn->real_escape_string($input['telefono']);
$tipo = $conn->real_escape_string($input['tipo_residente']);
$calle = $conn->real_escape_string($input['calle']);
$numero = $conn->real_escape_string($input['numero']);
$manzana = $conn->real_escape_string($input['manzana']);
$lote = $conn->real_escape_string($input['lote']);

// Insertar en la tabla residentes
$sql1 = "INSERT INTO residentes (nombre, email, telefono, tipo_residente) 
         VALUES ('$nombre', '$email', '$telefono', '$tipo')";

if ($conn->query($sql1) === TRUE) {
    $id_residente = $conn->insert_id;

    // Insertar en la tabla viviendas
    $sql2 = "INSERT INTO viviendas (id_residente, calle, numero, manzana, lote)
             VALUES ($id_residente, '$calle', '$numero', '$manzana', '$lote')";

    if ($conn->query($sql2) === TRUE) {

        // Generar usuario y contraseña
        $usuario_generado = strtolower(explode(" ", $nombre)[0]) . rand(1000, 9999);
        $contrasena_plana = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, 8);
        $contrasena_hash = password_hash($contrasena_plana, PASSWORD_DEFAULT);

        // Insertar en la tabla usuarios
        $sql3 = "INSERT INTO usuarios (id_residente, usuario, contrasena)
                 VALUES ($id_residente, '$usuario_generado', '$contrasena_hash')";

        if ($conn->query($sql3) === TRUE) {
            echo json_encode([
                "success" => true,
                "usuario" => $usuario_generado,
                "contrasena" => $contrasena_plana
            ]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al registrar en tabla usuarios: " . $conn->error]);
        }
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Error al registrar vivienda: " . $conn->error]);
    }
} else {
    http_response_code(500);
    echo json_encode(["error" => "Error al registrar residente: " . $conn->error]);
}

$conn->close();
?>

