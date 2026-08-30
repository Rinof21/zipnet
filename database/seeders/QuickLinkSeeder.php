<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\QuickLink;

class QuickLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $links = [
            ['title' => 'Silat', 'url' => 'https://silatfk.untan.ac.id', 'sort_order' => 1, 'is_active' => true],
            ['title' => 'Reservasi Ruang Sidang', 'url' => 'http://203.24.51.238:8015', 'sort_order' => 2, 'is_active' => true],
            ['title' => 'Website Fakultas', 'url' => 'https://kedokteran.untan.ac.id', 'sort_order' => 3, 'is_active' => true],
        ];

        foreach ($links as $link) {
            QuickLink::firstOrCreate(['title' => $link['title']], $link);
        }
    }
}
