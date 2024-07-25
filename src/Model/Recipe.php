<?php

namespace Mdchristien\PhpTest\Model;

class Recipe
{
    private $id;
    private $name;
    private $prepTime;
    private $difficulty;
    private $vegetarian;
    private $ratings = [];

    public function __construct($name, $prepTime, $difficulty, $vegetarian)
    {
        $this->name = $name;
        $this->prepTime = $prepTime;
        $this->difficulty = $difficulty;
        $this->vegetarian = $vegetarian;
    }

    // Getters and setters...

    public function addRating($rating)
    {
        $this->ratings[] = $rating;
    }

    public function getAverageRating()
    {
        if (empty($this->ratings)) {
            return 0;
        }
        return array_sum($this->ratings) / count($this->ratings);
    }
}
