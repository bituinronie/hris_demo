<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KioskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // initialize dummy kiosk
        $username = 'dummykiosk';
        $password = 'secret';

        $user = User::firstOrCreate(
            ['username' => $username],
            [
                'password' => Hash::make($password),
                'email' => 'dummykiosk@codx.io',
                'isActive' => true
            ]
        );

        $this->command->line("");
        $this->command->line("=============================================");
        $this->command->line("Dummy Kiosk Username: $username");
        $this->command->line("Dummy Kiosk Password: $password");
        $this->command->line("=============================================");
        $this->command->line("");

        // apply permissions and role
        $user->syncRoles(['Kiosk']);
        $user->syncPermissionByRole();
        $this->command->info('Dummy Kiosk Seeded!');
    }
}
