<?php

namespace Workbench\Database\Seeders;

use Illuminate\Database\Seeder;
use Workbench\App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // The panel auto-authenticates as this user, see AutoLogin middleware.
        User::factory()->create([
            'name' => 'Workbench User',
            'email' => 'workbench@example.com',
        ]);
    }
}
