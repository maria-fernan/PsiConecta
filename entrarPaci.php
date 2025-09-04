<?php
session_start();

// Conexão com o banco
$conn = new mysqli("localhost", "root", "", "psiconecta");
if ($conn->connect_error) {
    die("Erro ao conectar: " . $conn->connect_error);
}

// Pegando dados do formulário
$email = $_POST['email'];
$senha = $_POST['senha'];

// Consulta segura
$sql = "SELECT * FROM paciente WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Verifica senha
    if (password_verify($senha, $row['senha'])) {
        $_SESSION['idPaciente'] = $row['idPaciente'];
        $_SESSION['nome'] = $row['nome'];

        header("Location: dashboard.php");
        exit;
    } else {
        echo "Email ou senha incorretos.";
    }
} else {
    echo "Email ou senha incorretos.";
}

$stmt->close();
$conn->close();
?>
