<?php

$host = "localhost"; // nome do servidor MySQL
$user = "id20530039_marlon"; // usuário do MySQL
$pass = "P@ssw0rd1234"; // senha do MySQL
$dbname = "id20530039_bdfatec"; // nome do banco de dados

// Conexão com o banco de dados MySQL
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Verifica se houve erro na conexão
if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}
