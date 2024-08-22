<?php

namespace Database\Factories;
use App\Models\Category;

use Illuminate\Database\Eloquent\Factories\Factory;


class CategoryFactory extends Factory
{

    protected $model = Category::class;
    
    public function definition()
    {
        return [
            'name' => $this->faker->word, // Genera un nombre de categoría aleatorio
            'image' => $this->faker->imageUrl(640, 480, 'categories', true), // Genera una URL de imagen aleatoria
        ];
    }
}
