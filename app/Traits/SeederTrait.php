<?php
namespace App\Traits;

use App\Models\Dtr;
use App\Models\Employee;
use App\Models\Schedule;
use Carbon\CarbonPeriod;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * Seeder traits
 */
trait SeederTrait
{
    /**
     * Dummy Records
     */

     public $dummyEmployeeRecord = [
        'employee_number' => 'CODXIO',
        'last_name' => 'Doe',
        'first_name' => 'John',
        'middle_name' => 'Marx',
        'name_extension' => 'I',
        'birth_date' => '2001-01-01',
        'birth_place' => 'Gotham City',
        'gender' => 'MALE',
        'civil_status' => 'SINGLE',
        'height' => 5.2,
        'weight' => '125',
        'blood_type' => 'A+',
        'gsis' => 'g-1234567890',
        'pagibig' => 'p-1234567890',
        'philhealth' => 'ph-1234567890',
        'sss' => 's-1234567890',
        'tin' => 't-1234567890',
        'citizenship' => 'FILIPINO',
        'citizenship_by' => 'BIRTH',
        'citizenship_by_country' => null,
        'residential_housenum' => '111',
        'residential_street' => 'Blip Street',
        'residential_subdivision' => 'Royal',
        'residential_barangay' => 'Sto. Rio',
        'residential_city' => 'Gotham City',
        'residential_province' => 'Pampanga',
        'residential_zipcode' => '2009',
        'permanent_housenum' => '111',
        'permanent_street' => 'Blip Street',
        'permanent_subdivision' => 'Royal',
        'permanent_barangay' => 'Sto. Rio',
        'permanent_city' => 'Gotham City',
        'permanent_province' => 'Pampanga',
        'permanent_zipcode' => '2009',
        'telephone' => '323-1234',
        'mobile' => '09123456789',
        'email' => 'admin@codx.io',
        'spouse_last_name' => null,
        'spouse_first_name' => null,
        'spouse_middle_name' => null,
        'spouse_name_extension' => null,
        'spouse_occupation' => null,
        'spouse_telephone' => null,
        'spouse_employer_business' => null,
        'spouse_business_address' => null,
        'father_last_name' => 'Doe',
        'father_first_name' => 'Joseph',
        'father_middle_name' => 'Marx',
        'father_name_extension' => null,
        'mother_last_name' => 'Doe',
        'mother_first_name' => 'Kor',
        'mother_middle_name' => null,
        'is_affiliated_third' => false,
        'affiliated_third' => null,
        'is_affiliated_fourth' => false,
        'affiliated_fourth' => null,
        'is_found_guilty' => false,
        'found_guilty' => null,
        'is_criminally_charged' => false,
        'criminally_charged_date' => null,
        'criminally_charged_status' => null,
        'is_convicted' => false,
        'convicted' => null,
        'is_separated_service' => false,
        'separated_service' => null,
        'is_candidate' => false,
        'candidate' => null,
        'is_resigned' => false,
        'resigned' => null,
        'is_immigrant' => false,
        'immigrant' => null,
        'is_indigenous' => false,
        'indigenous' => null,
        'is_disabled' => false,
        'disabled' => null,
        'is_solo' => false,
        'solo' => null,
        'government_id_type' => 'GSIS',
        'government_id_number' => '12345676789',
        'issued_date' => '2020-01-01',
        'issued_place' => 'Gotham City',

        'memberships' => [
            'Region 3 Alumni Community of Heroes',
            'EMPLOYEES UNION'
        ],
        'skills' => [
            'Judo',
            'Computer Literate (MS Office Word, Excel and Powerpoint)',
            'driving'
        ],
        'recognitions' => [
            'KAPWA AWARDEE',
            'TABLE TENNIS TEAM COMPETITION 2ND PLACE PALARONG EMPLEYADO YEAR 5',
            '5th best student of the year'
        ],
     ];

    /**
     * creating permission by array of permissions and key
     * 
     * @param array $permissions
     * @param string $key
     * 
     * @return void
     */
    public function createPermissionsFor(array $permissions, string $key){
      
        $applicablePermissions = [
            'search','write','delete','restore','portal','print','access'
        ];

        foreach ($permissions as $permission) {
            if (in_array($permission, $applicablePermissions)) {
                $permissionName = "$permission $key";
                Permission::updateOrCreate(['name' => $permissionName]);
            }
        }

    }

    /**
     * initializing Administrator Role and permissions
     * 
     * @return void
     */
    public function initAdministrator(){
        $role = Role::where('name', 'Administrator')->first();
        if($role == null) {
            $role = Role::create(['name' => 'Administrator']);
        }

        $permissions = Permission::where('name','!=','access kiosk')->pluck('name');

        $role->syncPermissions($permissions);
    }

    /**
     * initializing Administrator Role and permissions
     * 
     * @return void
     */
    public function initHR(){
        $role = Role::where('name', 'HR')->first();
        if($role == null) {
            $role = Role::create(['name' => 'HR']);
        }

        $permissions = Permission::where('name','!=','access kiosk')->pluck('name');

        $role->syncPermissions($permissions);
    }


    /**
     * initializing Employee Role and permissions
     * 
     * @return void
     */
    public function initPayroll(){
        $role = Role::firstOrCreate(['name' => 'Payroll']);

        $permissions = Permission::where('name','LIKE','%portal%')->pluck('name');

        $role->syncPermissions($permissions);
    }

    /**
     * initializing Employee Role and permissions
     * 
     * @return void
     */
    public function initEmployee(){
        $role = Role::firstOrCreate(['name' => 'Employee']);

        $permissions = Permission::where('name','LIKE','%portal%')->pluck('name');

        $role->syncPermissions($permissions);
    }

    /**
     * initializing Employee Role and permissions
     * 
     * @return void
     */
    public function initAirportSupervisor(){
        $role = Role::firstOrCreate(['name' => 'Airport Supervisor']);

        $permissions = Permission::where('name','LIKE','%portal%')->orWhere('name','print dtr')->orWhere('name','LIKE','%schedule%')->pluck('name');
        // dd($permissions);
        $role->syncPermissions($permissions);
    }

    /**
     * initializing Kiosk Role and permissions
     * 
     * @return void
     */
    public function initKiosk(){
        $role = Role::firstOrCreate(['name' => 'Kiosk']);

        $permissions = ['access kiosk'];

        $role->syncPermissions($permissions);
    }

    /**
     * test schedule seeder
     * 
     * @return void
     */
    public function initTestSchedule(){
        // init Variables
        $fourDays = ['mon','tue','wed','thu'];
        $fiveDays = ['mon', 'tue', 'wed', 'thu','fri'];

        /**
         * 
         * @param Array $dayArray
         * 
         * $sched
         * @param String time_in
         * @param String lunch_out
         * @param String lunch_in
         * @param String time_out
         * @param String flexi_from *Optional
         * @param String flexi_to *Optional
         */
        $generateSheduleArray = function ($dayArray, $sched, $description) {
            $returnData = Arr::collapse(
                            array_map(function($day) use ($sched) {
                                return [
                                    $day . '_time_in' => $sched['time_in'],
                                    $day . '_lunch_out' => $sched['lunch_out'] ?? null,
                                    $day . '_lunch_in' => $sched['lunch_in'] ?? null,
                                    $day . '_time_out' => $sched['time_out'],
                                ];
                            }, $dayArray)
                        );

            $isFlexi = isset($sched['flexi_from']) && isset($sched['flexi_to']);

            $returnData['flexi_from'] = $isFlexi ? $sched['flexi_from'] : null;
            $returnData['flexi_to'] = $isFlexi ? $sched['flexi_to'] : null;

            $returnData['description'] = $description;

            return $returnData;
        };

        // 8 hrs sched
        Schedule::updateOrCreate(['code' => 'IO8'],
            $generateSheduleArray($fiveDays, [
                'time_in' => '07:00:00',
                'lunch_out' => '12:00:00',
                'lunch_in' => '13:00:00',
                'time_out' => '16:00:00'
            ], '8HRS WORK (SAMPLE)')
        );

        // 10 hrs sched
        Schedule::updateOrCreate(['code' => 'IO10'],
            $generateSheduleArray($fiveDays, [
                'time_in' => '08:00:00',
                'lunch_out' => '12:00:00',
                'lunch_in' => '13:00:00',
                'time_out' => '19:00:00',
                'flexi_from' => '07:00:00',
                'flexi_to' => '08:00:00'
            ], '10HRS WORK (SAMPLE) - FLEXI')
        );

        // Overnight sched
        Schedule::updateOrCreate(['code' => 'IONT'],
            $generateSheduleArray($fiveDays, [
                'time_in' => '21:00:00',
                'lunch_out' => '01:00:00',
                'lunch_in' => '02:00:00',
                'time_out' => '06:00:00'
            ], 'OVERNIGHT WORK (SAMPLE)')
        );
    }

    /**
     * Summary of initTestDtr
     * 
     * @param Employee $employee
     * 
     * @return void
     */
    public function initTestDtr($employeeId, $month = null, $year = null){
        $month = $month ?? date('m');
        $year = $year ?? date('y');

        $dateFrom = date('Y-m-d', strtotime("$year-$month-01"));
        $dateTo = date('Y-m-t', strtotime("$year-$month-01"));

        $period = CarbonPeriod::create($dateFrom, $dateTo);

        $pattern = [
            'normal',
            'add',
            'sub',
            'noentry'
        ];

        $bandiType = ['time_in','lunch_out','lunch_in','time_out'];

        // Iterate over the period
        foreach ($period as $date) {
            $refDate = $date->copy()->format('Y-m-d');

            $schedule = Employee::getScheduleByDate($employeeId, $refDate, true); // true => to strictly check sched

            $bandis = (object)[
                'time_in' => null,
                'lunch_out' => null,
                'lunch_in' => null,
                'time_out' => null,
            ];

            $isToAdd = true;

            if($schedule != null) {
                $timeIn = $schedule->time_in->timestamp;

                $isOnight = function ($bandiTemplate) use ($timeIn) {
                    return $bandiTemplate->timestamp < $timeIn;
                };

                foreach ($bandiType as $bandi) {
                    if($schedule->{$bandi} === null) {
                        $bandis->{$bandi} = null;

                        continue;
                    }

                    if ($isOnight($schedule->{$bandi}) && $isToAdd) {
                        $refDate = $date->copy()->addDay()->format('Y-m-d');
                        $isToAdd = false;
                    }

                    $patternToUse = $pattern[array_rand($pattern)];

                    $bandis->{$bandi} = match ($patternToUse) {
                        'normal' => Carbon::parse($refDate." ".$schedule->{$bandi}->format('H:i:s')),
                        'add' => Carbon::parse($refDate." ".$schedule->{$bandi}->addMinutes(rand(1,30))->format('H:i:s')),
                        'sub' => Carbon::parse($refDate." ".$schedule->{$bandi}->subMinutes(rand(1,30))->format('H:i:s')),
                        'noentry' => null,
                    };
                }
            }

            Dtr::updateOrCreate([
                'employee_id' => $employeeId,
                'ref_date' => $date
            ],[
                'time_in' => $bandis->time_in,
                'lunch_out' => $bandis->lunch_out,
                'lunch_in' => $bandis->lunch_in,
                'time_out' => $bandis->time_out
            ]);

        }

    }
}
