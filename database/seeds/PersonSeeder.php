<?php

use App\Models\Person;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the person seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Person::class, 50)->create();
    }
}