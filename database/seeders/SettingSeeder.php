<?php

namespace Stew\ImageUploader\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->truncate();
        DB::table('settings')->insert([
            'key' => 'filesystem_disk',
            'value' => 'disk_local',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('settings')->insert([
            'key' => 'disk_local',
            'value' => json_encode([
                'driver' => 'local',
                'root' => storage_path('app'),
                'throw' => false,
            ]),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
