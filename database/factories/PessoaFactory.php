<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PessoaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'pessoa_nome' => $this->faker->name(),
            'status' => 'A',
            'created_at' => now(),
            'update_at' => now(),
        ];
    }
}
