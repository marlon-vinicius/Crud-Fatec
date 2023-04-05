<?php

header('Access-Control-Allow-Origin: *');

$connect = new PDO("mysql:host=localhost;dbname=id20530039_bdfatec", "id20530039_marlon", "P@ssw0rd1234");  // Conecta com o banco de dados

$received_data = json_decode(file_get_contents("php://input")); // Recebe os dados passados pelo input e transforma em json

$data = array(); // Cria uma array vazia

if($received_data->query != '')
{
	// Retorna todos dados da tabela fatec_alunos de acordo com os paâmetros que foi passado
	$query = "
	SELECT * FROM fatec_alunos 
	WHERE first_name LIKE '%".$received_data->query."%' 
	OR last_name LIKE '%".$received_data->query."%' 
	ORDER BY id DESC
	";
}
else
{
	// Retorna todos os dados da tabela fatec_alunos ordenados decrescente por id
	$query = "
	SELECT * FROM fatec_alunos 
	ORDER BY id DESC
	";
}

$statement = $connect->prepare($query);

$statement->execute();

// Adiciona cada linha do resultado dentro da array $data
while($row = $statement->fetch(PDO::FETCH_ASSOC))
{
	$data[] = $row;
}

echo json_encode($data);

?>