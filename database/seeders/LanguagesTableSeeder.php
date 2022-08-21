<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Language::count() === 0) {
            $language = new Language();
            $language->locale = 'en';
            $language->name = 'English';
            $language->save();
        }
    }
}
