<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Data DEMO untuk lingkungan lokal/staging. Jangan dijalankan di produksi.
 */
class DemoSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->isProduction()) {
            $this->command?->error('DemoSeeder tidak boleh dijalankan di produksi.');

            return;
        }

        User::query()->updateOrCreate(
            ['email' => 'demo@example.com'],
            ['name' => 'Admin DEMO', 'password' => 'password'],
        );

        ContactMessage::factory()->count(5)->create([
            'subject' => '[DEMO] Permintaan informasi',
        ]);
    }
}
