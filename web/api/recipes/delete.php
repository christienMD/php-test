<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '/server/http/config/Database.php';
include_once '/server/http/models/Recipe.php';

$database = new Database();
$db = $database->connect();

$recipe = new Recipe($db);

$data = json_decode(file_get_contents("php://input"));

$recipe->id = $data->id;

if ($recipe->delete()) {
    echo json_encode(
        array('message' => 'Recipe Deleted')
    );
} else {
    echo json_encode(
        array('message' => 'Recipe Not Deleted')
    );
}
