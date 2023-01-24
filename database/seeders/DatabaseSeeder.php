<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        activity()->disableLogging();

        //**********************
        //* Settings/Data's
        $this->call([
            SettingSeeder::class,
            EmploymentStatusSeeder::class,
            RequestTypeSeeder::class,
            RemarkSeeder::class
        ]);

        //**********************
        //* Roles and Permissions
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
        ]);

        //**********************
        //* User Seeders
        $this->call([
            DummyUserSeeder::class,
            KioskSeeder::class
        ]);

        activity()->enableLogging();
    }
}
