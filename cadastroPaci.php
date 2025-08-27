<?php
$conexao = mysqli_connect("localhost","root","", "psiconecta") 
or die("Erro ao conectar. " . mysqli_error() );

$nome =  $_POST['nome'];
$cpf = $_POST['cpf'];
$dtNasc = $_POST['data'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$crp = $_POST['crp'];
$telefone = $_POST['telefone'];

$sql = "INSERT INTO psicologo ( nome, cpf, dtNasc, email, senha, crp) 
VALUES ( '$nome', '$cpf','$dtNasc', '$email', '$senha', '$crp') ";

mysqli_query($conexao, $sql)
or die("Erro na consulta. " . mysqli_error($conexao) );

$sql = "INSERT INTO telpsi (telefone, crp) 
VALUES ( '$telefone', '$crp') ";

mysqli_query($conexao, $sql)
or die("Erro na consulta. " . mysqli_error($conexao) );

header("Location: cadastroSucessoPsi.html");
?>