<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            UserSeeder::class,
            PadukuhanSeeder::class,
            OfficialSeeder::class,
            InstitutionSeeder::class,
            CategorySeeder::class,
            ArticleSeeder::class,
            BannerSeeder::class,
            AnnouncementSeeder::class,
            EventSeeder::class,
            AlbumSeeder::class,
            QuickLinkSeeder::class,
            MenuSeeder::class,
            FaqSeeder::class,
            LetterTypeSeeder::class,
            BudgetSeeder::class,
            IdmScoreSeeder::class,
            SdgsSeeder::class,
        ]);
    }
}
