<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contact;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition()
    {
        return [
            'cep' => $this->faker->postcode,
            'state' => $this->faker->state,
            'city' => $this->faker->city,
            'neighborhood' => $this->faker->secondaryAddress,
            'address' => $this->faker->streetName,
            'number' => $this->faker->buildingNumber,
            'contact_name' => $this->faker->name,
            'contact_email' => $this->faker->safeEmail,
            'contact_phone' => $this->faker->phoneNumber,
        ];
    }
}

