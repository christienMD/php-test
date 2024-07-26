<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '/server/http/models/Recipe.php';
include_once '/server/http/config/Database.php';


$database = new Database();
$db = $database->connect();

$recipe = new Recipe($db);

$data = json_decode(file_get_contents("php://input"));

$recipe->name = $data->name;
$recipe->prep_time = $data->prep_time;
$recipe->difficulty = $data->difficulty;
$recipe->vegetarian = $data->vegetarian;

if ($recipe->create()) {
    echo json_encode(
        array(
            'message' => 'Recipe Created',
            'recipe' => $recipe
        )
    );
} else {
    echo json_encode(
        array('message' => 'Recipe Not Created')
    );
}
