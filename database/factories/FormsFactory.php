<?php
// database/factories/FormsFactory.php

namespace Database\Factories;

use App\Models\Forms;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormsFactory extends Factory
{
    protected $model = Forms::class;

    public function definition()
    {
        return [
            'title' => $this->faker->text(50),
            'idStyle' => $this->faker->randomNumber(),
            'idUser' => $this->faker->randomNumber(),
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
        ];
    }
}
