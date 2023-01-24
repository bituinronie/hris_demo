<?php

namespace Database\Seeders;

use App\Models\Remark;
use Illuminate\Database\Seeder;

class RemarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Remark::updateOrCreate([
            'id' => 1
        ],[
            'code' => 'Initial',
            'description' => 'Initial'
        ]);

        Remark::updateOrCreate([
            'id' => 2
        ],[
            'code' => 'Original',
            'description' => 'Original'
        ]);

        Remark::updateOrCreate([
            'id' => 3
        ],[
            'code' => 'Promotion',
            'description' => 'Promotion'
        ]);

        Remark::updateOrCreate([
            'id' => 4
        ],[
            'code' => 'Transfer',
            'description' => 'Transfer'
        ]);

        Remark::updateOrCreate([
            'id' => 5
        ],[
            'code' => 'Re-employment',
            'description' => 'Re-employment'
        ]);

        Remark::updateOrCreate([
            'id' => 6
        ],[
            'code' => 'Reappointment',
            'description' => 'Reappointment'
        ]);

        Remark::updateOrCreate([
            'id' => 7
        ],[
            'code' => 'Reinstatement',
            'description' => 'Reinstatement'
        ]);

        Remark::updateOrCreate([
            'id' => 8
        ],[
            'code' => 'Reclassification',
            'description' => 'Reclassification'
        ]);

        Remark::updateOrCreate([
            'id' => 9
        ],[
            'code' => 'Demotion',
            'description' => 'Demotion'
        ]);

        Remark::updateOrCreate([
            'id' => 10
        ],[
            'code' => 'Salary Adjustment',
            'description' => 'Salary Adjustment'
        ]);

        Remark::updateOrCreate([
            'id' => 11
        ],[
            'code' => 'Step Increment',
            'description' => 'Step Increment'
        ]);

        Remark::updateOrCreate([
            'id' => 12
        ],[
            'code' => 'Detail',
            'description' => 'Detail'
        ]);

        Remark::updateOrCreate([
            'id' => 13
        ],[
            'code' => 'Change of Status',
            'description' => 'Change of Status'
        ]);

        Remark::updateOrCreate([
            'id' => 14
        ],[
            'code' => 'Renewal',
            'description' => 'Renewal'
        ]);

        Remark::updateOrCreate([
            'id' => 15
        ],[
            'code' => 'Secondment',
            'description' => 'Secondment'
        ]);

        Remark::updateOrCreate([
            'id' => 16
        ],[
            'code' => 'Probationary',
            'description' => 'Probationary'
        ]);

        Remark::updateOrCreate([
            'id' => 17
        ],[
            'code' => 'Resigned',
            'description' => 'Resigned'
        ]);

        Remark::updateOrCreate([
            'id' => 18
        ],[
            'code' => 'Compulsory Retired',
            'description' => 'Compulsory Retired'
        ]);

        Remark::updateOrCreate([
            'id' => 19
        ],[
            'code' => 'Dropped',
            'description' => 'Dropped From The Rolls'
        ]);

        Remark::updateOrCreate([
            'id' => 20
        ],[
            'code' => 'Deceased',
            'description' => 'Deceased'
        ]);

        Remark::updateOrCreate([
            'id' => 21
        ],[
            'code' => 'Hiring',
            'description' => 'Hiring'
        ]);

        Remark::updateOrCreate([
            'id' => 22
        ],[
            'code' => 'Suspension',
            'description' => 'Suspension'
        ]);

        Remark::updateOrCreate([
            'id' => 23
        ],[
            'code' => 'Dismissal',
            'description' => 'Dismissal'
        ]);

        Remark::updateOrCreate([
            'id' => 24
        ],[
            'code' => 'Leave w/o Pay',
            'description' => 'Leave w/o Pay'
        ]);

        Remark::updateOrCreate([
            'id' => 25
        ],[
            'code' => 'Resignation',
            'description' => 'Resignation'
        ]);

        Remark::updateOrCreate([
            'id' => 26
        ],[
            'code' => 'For Cancellation',
            'description' => 'For Cancellation'
        ]);

        Remark::updateOrCreate([
            'id' => 27
        ],[
            'code' => 'Others',
            'description' => 'Others'
        ]);

        Remark::updateOrCreate([
            'id' => 28
        ],[
            'code' => 'For Restoration',
            'description' => 'For Restoration'
        ]);

        Remark::updateOrCreate([
            'id' => 29
        ],[
            'code' => 'Optional Retired',
            'description' => 'Optional Retired'
        ]);
    }
}
