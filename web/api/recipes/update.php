<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT, PATCH');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '/server/http/config/Database.php';
include_once '/server/http/models/Recipe.php';

$database = new Database();
$db = $database->connect();

$recipe = new Recipe($db);

$data = json_decode(file_get_contents("php://input"));

$recipe->id = $data->id;
$recipe->name = $data->name;
$recipe->prep_time = $data->prep_time;
$recipe->difficulty = $data->difficulty;
$recipe->vegetarian = $data->vegetarian;

if ($recipe->update()) {
    echo json_encode(
        array(
            'message' => 'Recipe Updated',
            'recipe' => $recipe
        )
    );
} else {
    echo json_encode(
        array('message' => 'Recipe Not Updated')
    );
}
