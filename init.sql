CREATE TABLE IF NOT EXISTS recipes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    prep_time VARCHAR(50) NOT NULL,
    difficulty INT NOT NULL,
    vegetarian BOOLEAN NOT NULL
);

CREATE TABLE IF NOT EXISTS ratings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recipe_id INT NOT NULL,
    rating INT NOT NULL,
    FOREIGN KEY (recipe_id) REFERENCES recipes(id)
);

INSERT INTO recipes (name, prep_time, difficulty, vegetarian) VALUES
('Spaghetti Carbonara', '30 minutes', 2, false),
('Vegetable Stir Fry', '20 minutes', 1, true);