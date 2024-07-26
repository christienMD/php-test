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

-- Add some sample ratings
INSERT INTO ratings (recipe_id, rating) VALUES
(1, 4), (1, 5), (1, 4), (1, 3), (1, 5),  -- Ratings for Spaghetti Carbonara
(2, 3), (2, 4), (2, 5), (2, 4), (2, 3);  -- Ratings for Vegetable Stir Fry