<?php
header('Access-Control-Allow-Origin: *');

$connect = new PDO("mysql:host=localhost;dbname=id20530039_bdfatec", "id20530039_marlon", "P@ssw0rd1234"); // Conecta com o Banco de Dados
$received_data = json_decode(file_get_contents("php://input"));
$data = array();

// Se a ação for "fetchall" seleciona tudo da tabela fatec_alunos
if ($received_data->action == 'fetchall') {
    $query = "
 SELECT * FROM fatec_alunos 
 ORDER BY id DESC
 ";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data); // Retorna os dados encontrados
}

// Se a ação for "insert", faz uma inserção na tabela fatec_alunos
if ($received_data->action == 'insert') {
    $data = array(
        ':first_name' => $received_data->firstName,
        ':last_name' => $received_data->lastName
    );

    $query = "
 INSERT INTO fatec_alunos 
 (first_name, last_name) 
 VALUES (:first_name, :last_name)
 ";

    $statement = $connect->prepare($query);

    $statement->execute($data); // Executa a query
    
    // Mensagem indicando que o aluno foi adicionado
    $output = array(
        'message' => 'Aluno Adicionado' 
    );

    echo json_encode($output);
}

// Se a ação for "fetchSingle", faz um select do ID do registro de "received_data" na tabela fatec_alunos
if ($received_data->action == 'fetchSingle') {
    $query = "
 SELECT * FROM fatec_alunos 
 WHERE id = '" . $received_data->id . "'
 ";

    $statement = $connect->prepare($query);

    $statement->execute();

    $result = $statement->fetchAll();

    foreach ($result as $row) {
        $data['id'] = $row['id'];
        $data['first_name'] = $row['first_name'];
        $data['last_name'] = $row['last_name'];
    }

    echo json_encode($data);
}

// Se a ação for "update", faz um update na tabela fatec_alunos
if ($received_data->action == 'update') {
    $data = array(
        ':first_name' => $received_data->firstName,
        ':last_name' => $received_data->lastName,
        ':id' => $received_data->hiddenId
    );

    $query = "
 UPDATE fatec_alunos 
 SET first_name = :first_name, 
 last_name = :last_name 
 WHERE id = :id
 ";

    $statement = $connect->prepare($query);

    $statement->execute($data);
    // Retorna a menssagem que aluno foi atualizado
    $output = array(
        'message' => 'Aluno Atualizado'
    );

    echo json_encode($output);
}

// Se a ação for "delete", deleta o registro referente ao ID na tabela fatec_alunos
if ($received_data->action == 'delete') {
    $query = "
 DELETE FROM fatec_alunos 
 WHERE id = '" . $received_data->id . "'
 ";

    $statement = $connect->prepare($query);

    $statement->execute();

    // Mensagem indicando que o aluno foi deletado
    $output = array(
        'message' => 'Aluno Deletado'
    );

    echo json_encode($output);
}

?>