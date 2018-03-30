<?php

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the client seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Client::class, 5)->create();
    }
}