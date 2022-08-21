<?php

namespace Database\Seeders;

use App\Models\Priority;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PrioritiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Priority::count() === 0) {
            $now = Carbon::now();
            Priority::insert([
                ['value' => 1, 'name' => 'Low', 'created_at' => $now, 'updated_at' => $now],
                ['value' => 2, 'name' => 'Medium', 'created_at' => $now, 'updated_at' => $now],
                ['value' => 3, 'name' => 'High', 'created_at' => $now, 'updated_at' => $now],
                ['value' => 4, 'name' => 'Urgent', 'created_at' => $now, 'updated_at' => $now],
            ]);
        }
    }
}
