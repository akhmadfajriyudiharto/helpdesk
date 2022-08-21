<?php

namespace Database\Seeders;

use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Status::count() === 0) {
            $now = Carbon::now();
            Status::insert([
                ['name' => 'Open', 'created_at' => $now, 'updated_at' => $now],
                ['name' => 'Pending', 'created_at' => $now, 'updated_at' => $now],
                ['name' => 'Resolved', 'created_at' => $now, 'updated_at' => $now],
                ['name' => 'Closed', 'created_at' => $now, 'updated_at' => $now],
            ]);
        }
    }
}
