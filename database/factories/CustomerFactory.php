<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'phone' => fake()->numerify('08##########'),
            'email' => fake()->unique()->userName() . '@gmail.com',
            'address' => fake()->randomElement([
                'Jl. Sultan Fatah, Kadilangu, Kec. Demak, Kabupaten Demak',
                'Jl. Diponegoro, Bintoro, Kec. Demak, Kabupaten Demak',
                'Jl. Pangeran Diponegoro, Mangunjiwan, Kec. Demak, Kabupaten Demak',
                'Jl. Jend. Sudirman, Singorejo, Kec. Demak, Kabupaten Demak',
                'Jl. Kalidoro, Kalikondang, Kec. Demak, Kabupaten Demak',
                'Jl. Raya Mranggen, Mranggen, Kabupaten Demak',
                'Jl. Raya Semarang-Demak, Karangawen, Kabupaten Demak',
                'Jl. Raya Demak-Godong, Wonosalam, Kabupaten Demak',
                'Jl. Raya Bonang, Bonang, Kabupaten Demak',
                'Jl. Raya Sayung, Sayung, Kabupaten Demak',
            ]),
        ];
    }
}
