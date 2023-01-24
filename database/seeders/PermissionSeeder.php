<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Traits\SeederTrait;

class PermissionSeeder extends Seeder
{
    use SeederTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * PERMISSIONS
         * 
         * @param String 'search'
         * @param String 'write' // create & update
         * @param String 'delete'
         * @param String 'restore'
         * @param String 'portal'
         * @param String 'print'
         * 
         * @param String 'access' // for general mostly use on kiosk
         */

        // activity logs permissions
        $this->createPermissionsFor(['search'],'log');

        // settings permissions
        $this->createPermissionsFor(['search', 'write'],'setting');

        // roles permissions
        $this->createPermissionsFor(['search', 'write'],'role');

        // employee group permissions
        $this->createPermissionsFor(['search', 'write', 'delete', 'restore'],'employee group');

        // employee permissions
        $this->createPermissionsFor(['search', 'write', 'delete', 'restore', 'portal', 'print'],'employee');

        // division permissions
        $this->createPermissionsFor(['search', 'write', 'delete', 'restore'],'division');

        // salary grade permissions
        $this->createPermissionsFor(['search', 'write', 'delete', 'restore'],'salary grade');

        // position permissions
        $this->createPermissionsFor(['search', 'write', 'delete', 'restore', 'print'],'position');

        // employment status permissions
        $this->createPermissionsFor(['search', 'write'],'employment status');

        // remark permissions
        $this->createPermissionsFor(['search', 'write'],'remark');

        // service record permissions
        $this->createPermissionsFor(['search', 'write', 'delete', 'restore', 'print'],'service record');

        // user permissions
        $this->createPermissionsFor(['search', 'write'],'user');

        // schedule permissions
        $this->createPermissionsFor(['search', 'write', 'delete', 'restore'],'schedule');

        // special date permissions
        $this->createPermissionsFor(['search', 'write', 'delete', 'restore'],'special date');

        // employee schedule permissions
        $this->createPermissionsFor(['search', 'write', 'delete','portal'],'employee schedule');

        // dtr permissions
        $this->createPermissionsFor(['search', 'write', 'print','portal'],'dtr');

        // kiosk permissions
        $this->createPermissionsFor(['access'],'kiosk');

        // request type permissions
        $this->createPermissionsFor(['search', 'write'],'request type');

        // approver permissions
        $this->createPermissionsFor(['search', 'write'],'approver');

        // funding source permissions
        $this->createPermissionsFor(['search', 'write', 'delete', 'restore'],'funding source');

        // request permissions
        $this->createPermissionsFor(['search', 'write', 'delete', 'portal','print'],'request');

        // training permissions
        $this->createPermissionsFor(['search', 'write', 'delete', 'restore', 'portal', 'print'],'training');

        // applicant permissions
        $this->createPermissionsFor(['search', 'write', 'delete','print'],'applicant');

        // award permissions
        $this->createPermissionsFor(['search', 'write', 'delete','print'],'award');

        // offense permissions
        $this->createPermissionsFor(['search', 'write', 'delete','print'],'offense');

        // appraisal permissions
        $this->createPermissionsFor(['search', 'write', 'delete','print'],'appraisal');
    }
}
