<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '/server/http/config/Database.php';
include_once '/server/http/models/Recipe.php';

$database = new Database();
$db = $database->connect();

$recipe = new Recipe($db);

$recipe->id = isset($_GET['id']) ? $_GET['id'] : die();

if ($recipe->read_single()) {
    $recipe_arr = array(
        'id' => $recipe->id,
        'name' => $recipe->name,
        'prep_time' => $recipe->prep_time,
        'difficulty' => $recipe->difficulty,
        'vegetarian' => $recipe->vegetarian,
        'average_rating' => $recipe->average_rating
    );

    http_response_code(200);
    echo json_encode($recipe_arr);
} else {
    http_response_code(404);
    echo json_encode(array('message' => 'Recipe not found'));
}
