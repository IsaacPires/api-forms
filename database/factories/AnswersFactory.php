<?php
// database/factories/AnswersFactory.php

namespace Database\Factories;

use App\Models\Answers;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnswersFactory extends Factory
{
    protected $model = Answers::class;

    public function definition()
    {
        return [
            'answer' => $this->faker->sentence(),
            'idQuestion' => $this->faker->randomNumber(),
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
            'idClient' => $this->faker->randomNumber(),
        ];
    }
}
