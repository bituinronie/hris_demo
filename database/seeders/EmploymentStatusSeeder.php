<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmploymentStatus;

class EmploymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        EmploymentStatus::updateOrCreate([
            'id' => 1
        ],[
            'code' => 'Presidential Appointee',
            'description' => 'Presidential Appointee'
        ]);

        EmploymentStatus::updateOrCreate([
            'id' => 2
        ],[
            'code' => 'Permanent',
            'description' => 'Permanent'
        ]);

        EmploymentStatus::updateOrCreate([
            'id' => 3
        ],[
            'code' => 'Co-Terminus with the Appointing Authority',
            'description' => 'Co-Terminus with the Appointing Authority'
        ]);

        EmploymentStatus::updateOrCreate([
            'id' => 4
        ],[
            'code' => 'Temporary',
            'description' => 'Temporary'
        ]);

        EmploymentStatus::updateOrCreate([
            'id' => 5
        ],[
            'code' => 'Probationary',
            'description' => 'Probationary'
        ]);

        EmploymentStatus::updateOrCreate([
            'id' => 6
        ],[
            'code' => 'Contractual',
            'description' => 'Contractual'
        ]);

        EmploymentStatus::updateOrCreate([
            'id' => 7
        ],[
            'code' => 'Substitute',
            'description' => 'Substitute'
        ]);

        EmploymentStatus::updateOrCreate([
            'id' => 8
        ],[
            'code' => 'Original Appointment',
            'description' => 'Original Appointment'
        ]);

        EmploymentStatus::updateOrCreate([
            'id' => 9
        ],[
            'code' => 'Casual',
            'description' => 'Casual'
        ]);

        EmploymentStatus::updateOrCreate([
            'id' => 10
        ],[
            'code' => 'JO',
            'description' => 'Job Order'
        ]);

        EmploymentStatus::updateOrCreate([
            'id' => 11
        ],[
            'code' => 'COS',
            'description' => 'Contract of Services'
        ]);

        EmploymentStatus::updateOrCreate([
            'id' => 12
        ],[
            'code' => 'Co-Terminus with the Incumbent',
            'description' => 'Co-Terminus with the Incumbent'
        ]);

        EmploymentStatus::updateOrCreate([
            'id' => 13
        ],[
            'code' => 'Technical Assistant / Consultant',
            'description' => 'Technical Assistant / Consultant'
        ]);

    }
}
