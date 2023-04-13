<?php
header('Access-Control-Allow-Origin: *');

$connect = new PDO("mysql:host=localhost;dbname=id20530039_bdfatec", "id20530039_marlon", "P@ssw0rd1234"); // Conecta com o Banco de Dados
$received_data = json_decode(file_get_contents("php://input"));
$data = array();

if ($received_data->action == 'fetchall') {
    $query = "
 SELECT * FROM fatec_professores 
 ORDER BY id DESC
 ";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data);
}

if ($received_data->action == 'insert') {
    $data = array(
        ':nome' => $received_data->nome,
        ':endereco' => $received_data->endereco,
        ':curso' => $received_data->curso,
        ':salario' => $received_data->salario,
    );

    $query = "
 INSERT INTO fatec_professores 
 (nome, endereco, curso, salario) 
 VALUES (:nome, :endereco, :curso, :salario)
 ";

    $statement = $connect->prepare($query);

    $statement->execute($data); // Executa a query
    
    // Mensagem indicando que o aluno foi adicionado
    $output = array(
        'message' => 'Professor Adicionado' 
    );

    echo json_encode($output);
}

if ($received_data->action == 'fetchSingle') {
    $query = "
 SELECT * FROM fatec_professores 
 WHERE id = '" . $received_data->id . "'
 ";

    $statement = $connect->prepare($query);

    $statement->execute();

    $result = $statement->fetchAll();

    foreach ($result as $row) {
        $data['id'] = $row['id'];
        $data['nome'] = $row['nome'];
        $data['endereco'] = $row['endereco'];
        $data['curso'] = $row['curso'];
        $data['salario'] = $row['salario'];
    }

    echo json_encode($data);
}

if ($received_data->action == 'update') {
    $data = array(
        ':nome' => $received_data->nome,
        ':endereco' => $received_data->endereco,
        ':curso' => $received_data->curso,
        ':salario' => $received_data->salario,
        ':id' => $received_data->hiddenId
    );

    $query = "
 UPDATE fatec_professores 
 SET nome = :nome, 
 endereco = :endereco, 
 curso = :curso, 
 salario = :salario
 WHERE id = :id
 ";

    $statement = $connect->prepare($query);

    $statement->execute($data);
    // Retorna a menssagem que aluno foi atualizado
    $output = array(
        'message' => 'Professor Atualizado'
    );

    echo json_encode($output);
}

if ($received_data->action == 'delete') {
    $query = "
 DELETE FROM fatec_professores 
 WHERE id = '" . $received_data->id . "'
 ";

    $statement = $connect->prepare($query);

    $statement->execute();

    $output = array(
        'message' => 'Professor Deletado'
    );

    echo json_encode($output);
}

?>