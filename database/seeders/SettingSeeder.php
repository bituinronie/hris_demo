<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Setting::firstOrCreate(['key' => 'UPDATE_EMPLOYEE'], ['value' => ['from' => null, 'to' => null]]);
        // Setting::firstOrCreate(['key' => 'REPORT_ADDRESS'], ['value' => '123 Sample Address, South Korea']);
        // Setting::firstOrCreate(['key' => 'REPORT_CONTACT_NUMBER'], ['value' => '0912-123-1234 (045) 323-2332']);
        // Setting::firstOrCreate(['key' => 'FLEXI'], ['value' => ['from' => "07:00:00", 'to' => "08:00:00"]]);
        Setting::firstOrCreate(['key' => 'ACTIVE_TRANCHE'], ['value' => '2']);
        Setting::firstOrCreate(['key' => 'ANNUAL_SPECIAL_LEAVE'], ['value' => '3']);
        Setting::firstOrCreate(['key' => 'ANNUAL_MANDATORY_LEAVE'], ['value' => '5']);
    }
}
