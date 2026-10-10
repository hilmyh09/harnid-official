<?php

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Store> */
class StoreFactory extends Factory
{
    protected $model = Store::class;

    public function definition(): array
    {
        return [
            'name' => 'Harnid '.fake()->city(),
            'city' => fake()->city(),
            'address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
            'hours' => '10.00–21.00 WIB',
        ];
    }
}
