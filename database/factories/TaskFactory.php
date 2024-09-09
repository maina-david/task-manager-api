<?php

namespace Database\Factories;

use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->unique()->sentence(4),
            'description' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(TaskStatus::cases())->value,
            'due_date' => Carbon::now()->addDays($this->faker->numberBetween(1, 30)),
        ];
    }
}