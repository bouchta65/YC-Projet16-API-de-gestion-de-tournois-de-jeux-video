<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Tournoi;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Matche>
 */
class MatcheFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'tournoi_id' => Tournoi::factory(),
            'player_1_id' => User::factory(),
            'player_2_id' => User::factory(),
            'score_player_1' => $this->faker->numberBetween(0, 10),
            'score_player_2' => $this->faker->numberBetween(0, 10),
            'match_date' => $this->faker->dateTimeThisYear(),
        ];
    }
}
