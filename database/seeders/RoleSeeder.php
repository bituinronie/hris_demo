<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Traits\SeederTrait;

class RoleSeeder extends Seeder
{
    use SeederTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // seed Administrator role and permissions
        $this->initAdministrator();

        // seed Employee role and permissions
        $this->initEmployee();

        // seed Kiosk Role
        $this->initKiosk();

        // seed HR role and permissions
        $this->initHR();

        // seed Payroll role and permissions
        $this->initPayroll();

        // see AirportSupervisor role and permission
        $this->initAirportSupervisor();
    }
}
