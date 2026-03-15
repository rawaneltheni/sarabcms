<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class PageContentSeeder extends Seeder
{
    public function run(): void
    {
        $htmlPath = database_path('seeders/data/homepage.html');

        if (! file_exists($htmlPath)) {
            throw new RuntimeException("Homepage HTML seed file not found: {$htmlPath}");
        }

        $content = file_get_contents($htmlPath);

        if ($content === false) {
            throw new RuntimeException("Unable to read homepage HTML seed file: {$htmlPath}");
        }

        DB::table('page_contents')->updateOrInsert(
            ['key' => 'homepage_raw_html'],
            [
                'title' => 'Sarab homepage HTML snapshot',
                'content' => $content,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }
}
