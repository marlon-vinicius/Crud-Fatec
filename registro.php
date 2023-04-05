<?php

ob_start();

session_start(); // Inicia a sessão

require_once 'config.php';

// Verifica se a requisição foi feita com o método POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe as informações do formulário
    $nome = $_POST['nome_cad'];
    $email = $_POST['email_cad'];
    $senha = $_POST['senha_cad'];

    // Verifica se o email já está em uso
    $query = "SELECT * FROM fatec_admin WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    // Se o email já estiver em uso, exibe mensagem
    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Este email já está em uso!');</script>";
    } else {
        // Insere o novo usuário no banco de dados
        $query = "INSERT INTO fatec_admin (nome, email, senha) VALUES ('$nome', '$email', md5('$senha'))";
        if (mysqli_query($conn, $query)) {
            // Se o cadastro for bem sucedido, exibe uma mensagem e redireciona para a tela de login
            echo '<script>alert("Usuário cadastrado com sucesso!")</script>';
            header("Location: index.html#paralogin");
        } else {
            // Se houver um erro ao cadastrar o usuário, exibe mensagem e redireciona para a tela de cadastro
            echo '<script>alert("Erro ao cadastrar usuário!")</script>';
            header("Location: index.html#paracadastro");
        }
    }
}

ob_end_flush();

/*
CREATE TABLE fatec_admin (
id INT(11) NOT NULL AUTO_INCREMENT,
nome VARCHAR(100) NOT NULL,
email VARCHAR(100) NOT NULL,
senha VARCHAR(100) NOT NULL,
PRIMARY KEY (id),
UNIQUE KEY email (email)
);
*/
?>