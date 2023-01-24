<?php

namespace Database\Seeders;

use App\Models\User;

use App\Models\Employee;

use App\Models\Schedule;
use App\Traits\CronTrait;
use App\Traits\SeederTrait;
use App\Models\EmployeeGroup;
use App\Models\ServiceRecord;
use Illuminate\Database\Seeder;
use App\Models\EmployeeSchedule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DummyUserSeeder extends Seeder
{
    use SeederTrait, CronTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        $id = 1;

        $user = User::find($id);
        $username = 'doecodxio';
        $defPassword = 'secret';
        $email = 'admin@codx.io';
        
        if($user == null) {
            $avoidingUser = User::create([
                'id' => $id,
                'username' => $username,
                'password' => Hash::make($defPassword),
                'email' => $email,
            ]);
            $avoidingUser->delete();

            // starts on creating dummy user
            $isCreateDummy = $this->command->askWithCompletion('Do you want to create a dummy user? (Y/N)', ['Y', 'N','y','n'], 'N');
            if($isCreateDummy == 'N' || $isCreateDummy == 'n')
                return null;
        }else {
            $isDeleteDummy = $this->command->askWithCompletion('Do you want to delete the dummy user? (Y/N)', ['Y', 'N','y','n'], 'N');
            if($isDeleteDummy == 'Y' || $isDeleteDummy == 'y') {
                $user->delete();

                $this->command->info('Dummy User Deleted!');
                return null;
            }

        }

        $this->command->info('Dummy User Creating...');

        $isUserInfoShow = false;
        if($user == null) {
            // credential decleration
            $password = $this->command->ask("Set dummy user password", $defPassword);

            $user = User::create([
                'id' => $id,
                'username' => $username,
                'password' => Hash::make($password),
                'email' => $email,
                'isActive' => true
            ]);

            $this->command->line("");
            $this->command->line("=============================================");
            $this->command->line("Dummy User Username: $username");
            $this->command->line("Dummy User Password: $password");
            $this->command->line("=============================================");
            $this->command->line("");

            $isUserInfoShow = true;
        }else {
            $isResetPassword = $this->command->askWithCompletion('Do you want to reset dummy user password? (Y/N)', ['Y', 'N', 'y', 'n'], 'N');
            if($isResetPassword == 'Y' || $isResetPassword == 'y') {
                $password = $this->command->ask("Set dummy user password", $defPassword);
                $user->password = Hash::make($password);

                $this->command->line("");
                $this->command->line("=============================================");
                $this->command->line("Dummy User Username: $username");
                $this->command->line("Dummy User Password: $password");
                $this->command->line("=============================================");
                $this->command->line("");

                $isUserInfoShow = true;
            }
       }

        // apply permissions and role
        $user->syncRoles(['Administrator']);
        $user->syncPermissionByRole();

        if (!$isUserInfoShow) {
            $this->command->line("");
            $this->command->line("=============================================");
            $this->command->line("Dummy User Username: $username");
            $this->command->line("=============================================");
            $this->command->line("");
        }

        $this->command->info('Dummy User Seeded!');

        // employee validation records
        $employee = Employee::findByUserId($user->id);
        if ($employee == null) {
            $isCreateEmployee = $this->command->askWithCompletion('Do you want to add employee to dummy user? (Y/N)', ['Y', 'N','y','n'], 'N');
            if($isCreateEmployee == 'N' || $isCreateEmployee == 'n')
                return null;
        }else {
            $isDeleteDummy = $this->command->askWithCompletion('Do you want to remove the applied employee to dummy user? (Y/N)', ['Y', 'N','y','n'], 'N');
            if($isDeleteDummy == 'Y' || $isDeleteDummy == 'y') {
                $employee->forceDelete();

                // removing test schedule
                Schedule::where('code','IO8')->withTrashed()->first()?->forceDelete();
                Schedule::where('code','IO10')->withTrashed()->first()?->forceDelete();
                Schedule::where('code','IONT')->withTrashed()->first()?->forceDelete();

                // removing test employee group
                EmployeeGroup::where('code','SAMPLE GROUP 1')->withTrashed()->first()?->forceDelete();
                EmployeeGroup::where('code','SAMPLE GROUP 2')->withTrashed()->first()?->forceDelete();

                $this->command->info('Employee Record Removed!');

                return null;
            }
        }

        //*=======================================
        //* FOR TESTING PURPOSES
        //*=======================================

        // applying records
        $this->command->info('Employee Record Initializing...');
        $employee = Employee::updateOrCreate(['user_id' => $user->id], $this->dummyEmployeeRecord);

        $this->command->line("Test Employee Groups Seeding...");
        EmployeeGroup::updateOrCreate([
            'code' => 'SAMPLE GROUP 1'
        ],[
            'description' => 'SAMPLE GROUP 1'
        ]);

        EmployeeGroup::updateOrCreate([
            'code' => 'SAMPLE GROUP 2'
        ],[
            'description' => 'SAMPLE GROUP 1'
        ]);

        // Service Record
        $this->command->line("Assigning Test Service Record...");
        ServiceRecord::updateOrCreate([
            'employee_id' => $employee->id,
            'date_from' => '2021-01-01',
        ],[
            'remark_id' => 1,
            'employee_group_id' => EmployeeGroup::findByCode('SAMPLE GROUP 1')->id,
            'positionOnPrint' => 'Test Position I',
            'salary' => 35000.00,
            'divisionOnPrint' => 'Test Division',
            'employment_status_id' => 2,
            'show_in_reports' => true,
            'date_hired' => true,
            'place_of_work' => 'Test Place of Work',
            'is_wfh' => true,
            'classification' => 'KEY',
            'level' => '1ST'
        ]);

        // Schedule
        $this->command->line("Test Schedules Seeding...");
        $this->initTestSchedule();

        // Assigning Schedule
        $this->command->line("Assigning Test Schedules...");
        EmployeeSchedule::updateOrCreate([
            'employee_id' => $employee->id,
            'schedule_id' => Schedule::findByCode('IO8')->id,
            'effective_date' => '2021-01-01'
        ]);

        EmployeeSchedule::updateOrCreate([
            'employee_id' => $employee->id,
            'schedule_id' => Schedule::findByCode('IO10')->id,
            'effective_date' => '2021-01-12'
        ]);

        EmployeeSchedule::updateOrCreate([
            'employee_id' => $employee->id,
            'schedule_id' => Schedule::findByCode('IONT')->id,
            'effective_date' => '2021-01-19'
        ]);

        $this->command->line("Test DTR's Seeding...");
        $month = 01;
        $year = 2021;

        // Generate DTR
        $this->generateDtr($employee->id, $month, $year); // January DTR

        // Sample Bandis
        $this->initTestDtr($employee->id, $month, $year);

        $this->command->info('Employee Record Applied.');
        Schema::enableForeignKeyConstraints();
    }
}
