<?php

use App\Models\Contact;
use App\Models\Message;
use Illuminate\Database\Seeder;

class MessageGeneratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Contact::class, 500)->create()->each(function ($c) {
            $c->messages()->saveMany(factory(Message::class, 150)->make());
        });
    }
}
