<?php
// Conexão com o banco (orientado a objeto)
$conn = new mysqli("localhost", "root", "", "psiconecta");

// Verifica se deu erro na conexão
if ($conn->connect_error) {
    die("Erro ao conectar: " . $conn->connect_error);
}

// Pegando os dados do formulário
$email    = $_POST['email'];
$nome     = $_POST['nome'];
$dtNasc   = $_POST['data'];
$senha    = $_POST['senha'];
$telefone = $_POST['telefone'];

// 1. Verificar se o email já existe
$sql = "SELECT idPaciente FROM paciente WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Esse e-mail já está cadastrado!";
} else {
    // 2. Gerar hash da senha
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // 3. Inserir paciente
    $sql = "INSERT INTO paciente (email, nome, dtNasc, senha) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $email, $nome, $dtNasc, $senhaHash);

    if ($stmt->execute()) {
        // Pega o ID gerado
        $idPaciente = $stmt->insert_id;

        // 4. Inserir telefone
        $sqlTel = "INSERT INTO telpaci (telefone, idPaciente) VALUES (?, ?)";
        $stmtTel = $conn->prepare($sqlTel);
        $stmtTel->bind_param("si", $telefone, $idPaciente);
        $stmtTel->execute();

        // 5. Redireciona para página de sucesso
        header("Location: cadastroSucessoPaci.html");
        exit;
    } else {
        echo "Erro ao cadastrar paciente: " . $conn->error;
    }
}

// Fecha conexões
$stmt->close();
$conn->close();
?>
