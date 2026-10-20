<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::UpdateOrCreate([
             'name' => 'Admin Tiket',
             'email' => 'admin@gmail.com',
             'password' => Hash::make('admin123'),
             'role' => 'admin'
        ]);

        // Seed data for the events table
        Event::create([
            'title' => 'Konser Musik Jazz Gunung',
            'category' => 'Musik',
            'ticket_price' => 150000,
            'description' => 'Festival musik jazz tahunan yang diadakan di alam terbuka dengan suasana pegunungan yang sejuk.',
            'image' => null,
        ]);

        Event::create([
            'title' => 'Tech Innovate Seminar 2026',
            'category' => 'Seminar',
            'ticket_price' => 75000,
            'description' => 'Seminar teknologi nasional membahas tren kecerdasan buatan (AI) dan pengembangan web modern.',
            'image' => null,
        ]);

        Event::create([
            'title' => 'Festival Kuliner Nusantara',
            'category' => 'Festival',
            'ticket_price' => 25000,
            'description' => 'Pameran makanan tradisional dari berbagai daerah di Indonesia dengan cita rasa autentik.',
            'image' => null,
        ]);
    }
}
