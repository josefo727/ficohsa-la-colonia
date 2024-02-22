<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'josefo727@gmail.com',
        ]);

        $this->call(GeneralSettingSeeder::class);
    }
}
