<?php

namespace Database\Factories;

use App\Models\Tournoi;
use Illuminate\Database\Eloquent\Factories\Factory;

class TournoiFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tournoi::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'rules' => $this->faker->word,
            'nb_players' => $this->faker->numberBetween(2, 10),
            'image' => $this->faker->imageUrl(),
            'creator_id' => \App\Models\User::factory(),
        ];
    }
}
