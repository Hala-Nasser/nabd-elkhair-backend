<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\StaticPagesSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            StaticPagesSeeder::class,
        ]);
    }
}
