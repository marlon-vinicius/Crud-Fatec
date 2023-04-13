<?php

header('Access-Control-Allow-Origin: *');

$connect = new PDO("mysql:host=localhost;dbname=id20530039_bdfatec", "id20530039_marlon", "P@ssw0rd1234");  // Conecta com o banco de dados

$received_data = json_decode(file_get_contents("php://input")); // Recebe os dados passados pelo input e transforma em json

$data = array(); // Cria uma array vazia

if($received_data->query != '')
{
	$query = "
	SELECT * FROM fatec_professores 
	WHERE nome LIKE '%".$received_data->query."%' 
	OR endereco LIKE '%".$received_data->query."%' 
	OR curso LIKE '%".$received_data->query."%' 
	OR salario LIKE '%".$received_data->query."%' 
	ORDER BY id DESC
	";
}
else
{
	$query = "
	SELECT * FROM fatec_professores
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