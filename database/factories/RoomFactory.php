<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\Category;
use App\Models\View;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Room::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'number' => $this->faker->unique()->numerify('###'),
            'description' => $this->faker->sentence(7),
            'category_id' => Category::pluck('id')->random(),
            'view_id' => View::pluck('id')->random(),
            'rate' => $this->faker->numberBetween($min = 10, $max = 100)
        ];
    }
}
