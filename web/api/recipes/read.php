<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '/server/http/config/Database.php';
include_once '/server/http/models/Recipe.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate recipe object
$recipe = new Recipe($db);

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
$start = ($page - 1) * $per_page;

// Recipe read query
$result = $recipe->read($start, $per_page);

// Get row count
$num = $result->rowCount();

if ($num > 0) {
    // Recipe array
    $recipes_arr = array();
    $recipes_arr['metadata'] = array(
        'total_count' => $recipe->getTotalCount(),
        'page' => $page,
        'per_page' => $per_page
    );
    $recipes_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $recipe_item = array(
            'id' => $id,
            'name' => $name,
            'prep_time' => $prep_time,
            'difficulty' => (int)$difficulty,
            'vegetarian' => (bool)$vegetarian,
            'ratings' => array(
                'average' => $average_rating ? round((float)$average_rating, 1) : null,
                'count' => (int)$rating_count
            )
        );

        // Push to "data"
        array_push($recipes_arr['data'], $recipe_item);
    }

    // Set response code - 200 OK
    http_response_code(200);

    // Turn to JSON & output
    echo json_encode($recipes_arr);
} else {
    // Set response code - 404 Not found
    http_response_code(404);

    // No Recipes
    echo json_encode(
        array('message' => 'No Recipes Found')
    );
}