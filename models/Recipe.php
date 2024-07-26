<?php
class Recipe
{
    // db connection and table name
    private $conn;
    private $table = 'recipes';

    // properties
    public $id;
    public $name;
    public $prep_time;
    public $difficulty;
    public $vegetarian;
    public $ratings = [];
    public $average_rating;
    public $rating_count;

    // constructor with db connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read all recipes
    public function read($start = 0, $limit = 10)
    {
        $query = "SELECT r.id, r.name, r.prep_time, r.difficulty, r.vegetarian, 
                     AVG(rt.rating) as average_rating, COUNT(rt.id) as rating_count
              FROM " . $this->table . " r
              LEFT JOIN ratings rt ON r.id = rt.recipe_id
              GROUP BY r.id
              ORDER BY r.name
              LIMIT :start, :limit";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;
    }

    public function getTotalCount()
    {
        $query = "SELECT COUNT(*) as total FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    // create recipe
    public function create()
    {
        $query = "INSERT INTO " . $this->table . " 
                  SET name = :name, prep_time = :prep_time, difficulty = :difficulty, vegetarian = :vegetarian";

        $stmt = $this->conn->prepare($query);

        // sanitize inputs
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->prep_time = htmlspecialchars(strip_tags($this->prep_time));
        $this->difficulty = htmlspecialchars(strip_tags($this->difficulty));
        $this->vegetarian = htmlspecialchars(strip_tags($this->vegetarian));

        // bind parameters
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':prep_time', $this->prep_time);
        $stmt->bindParam(':difficulty', $this->difficulty);
        $stmt->bindParam(':vegetarian', $this->vegetarian);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // get single recipe
    public function read_single()
    {
        $query = "SELECT r.id, r.name, r.prep_time, r.difficulty, r.vegetarian, 
                     AVG(rt.rating) as average_rating, COUNT(rt.id) as rating_count
              FROM " . $this->table . " r
              LEFT JOIN ratings rt ON r.id = rt.recipe_id
              WHERE r.id = ?
              GROUP BY r.id
              LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->name = $row['name'];
            $this->prep_time = $row['prep_time'];
            $this->difficulty = $row['difficulty'];
            $this->vegetarian = $row['vegetarian'];
            $this->average_rating = $row['average_rating'];
            $this->rating_count = $row['rating_count'];
            return true;
        }
        return false;
    }

    // update recipe
    public function update()
    {
        $query = "UPDATE " . $this->table . "
                  SET name = :name, prep_time = :prep_time, difficulty = :difficulty, vegetarian = :vegetarian
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // sanitize inputs
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->prep_time = htmlspecialchars(strip_tags($this->prep_time));
        $this->difficulty = htmlspecialchars(strip_tags($this->difficulty));
        $this->vegetarian = htmlspecialchars(strip_tags($this->vegetarian));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind parameters
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':prep_time', $this->prep_time);
        $stmt->bindParam(':difficulty', $this->difficulty);
        $stmt->bindParam(':vegetarian', $this->vegetarian);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // delete recipe
    public function delete()
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // search recipes
    public function search($keywords)
    {
        $query = "SELECT r.id, r.name, r.prep_time, r.difficulty, r.vegetarian, 
                         AVG(rt.rating) as average_rating
                  FROM " . $this->table . " r
                  LEFT JOIN ratings rt ON r.id = rt.recipe_id
                  WHERE r.name LIKE ? OR r.prep_time LIKE ? OR r.difficulty LIKE ?
                  GROUP BY r.id
                  ORDER BY r.name";

        $stmt = $this->conn->prepare($query);

        $keywords = htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";

        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->bindParam(3, $keywords);

        $stmt->execute();

        return $stmt;
    }

    // rate recipe
    public function rate($rating)
    {
        $query = "INSERT INTO ratings (recipe_id, rating) VALUES (:recipe_id, :rating)";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $rating = htmlspecialchars(strip_tags($rating));

        $stmt->bindParam(':recipe_id', $this->id);
        $stmt->bindParam(':rating', $rating);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
