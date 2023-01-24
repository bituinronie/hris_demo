<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\Division;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Schema::disableForeignKeyConstraints();
        
     //    $division = Division::updateOrCreate(
     //        ['code'=>'OUSEC'],
     //        [
     //             'name'=>'Office of the Administrator',
     //             'office_group'=> NULL
     //        ]
     //   );
     //   $division = Division::updateOrCreate(
     //        ['code'=>'PAD'],
     //        [
     //             'name'=>'Public Affairs Division',
     //             'office_group'=> 1
     //        ]
     //   );
     //   $division = Division::updateOrCreate(
     //        ['code'=>'ODA'],
     //        [
     //             'name'=>'Office of the Deputy Administrator',
     //             'office_group'=> NULL
     //        ]
     //   );
     //   $division = Division::updateOrCreate(
     //        ['code'=>'AFS'],
     //        [
     //             'name'=>'Administrative and Finance Service',
     //             'office_group'=> NULL
     //        ]
     //   );
     //   $division = Division::updateOrCreate(
     //        ['code'=>'AD'],
     //        [
     //             'name'=>'Administrative Division',
     //             'office_group'=> 4
     //        ]
     //   );
     //   $division = Division::updateOrCreate(
     //        ['code'=>'FAD'],
     //        [
     //             'name'=>'Finance and Accounting Division',
     //             'office_group'=> 4
     //        ]
     //   );
     //   $division = Division::updateOrCreate(
     //        ['code'=>'BD'],
     //        [
     //             'name'=>'Budget Division',
     //             'office_group'=> 4
     //        ]
     //   );
     //   $division = Division::updateOrCreate(
     //        ['code'=>'PL'],
     //        [
     //             'name'=>'Planning Division',
     //             'office_group'=> 4
     //        ]
     //   );
     //   $division = Division::updateOrCreate(
     //        ['code'=>'TSRMS'],
     //        [
     //             'name'=>'Transport Security Risk Management Service',
     //             'office_group'=> NULL
     //        ]
     //   );
     //   $division = Division::updateOrCreate(
     //        ['code'=>'SDDMD'],
     //        [
     //             'name'=>'Systems Development and Data Management Division',
     //             'office_group'=> 9
     //        ]
     //   );
     //   $division = Division::updateOrCreate(
     //        ['code'=>'TRAD'],
     //        [
     //             'name'=>'Threat and Risk Assessment Division',
     //             'office_group'=> 9
     //        ]
     //   );
     //   $division = Division::updateOrCreate(
     //        ['code'=>'TSRSD'],
     //        [
     //             'name'=>'Transportation Security Risk Surveillance Division',
     //             'office_group'=> 9
     //        ]
     //   );
     //   $division = Division::updateOrCreate(
     //        ['code'=>'TSPPS'],
     //        [
     //             'name'=>'Transport Security Policy and Program Service',
     //             'office_group'=> NULL
     //        ]
     //   );
     //   $division = Division::updateOrCreate(
     //        ['code'=>'PFDD'],
     //        [
     //             'name'=>'Policy Formulation and Development Division',
     //             'office_group'=> 1
     //        ]
     //   );
     //   $division = Division::updateOrCreate(
     //        ['code'=>'IAD'],
     //        [
     //             'name'=>'International Affairs Division',
     //             'office_group'=> 1
     //        ]
     //   );
     //   $division = Division::updateOrCreate(
     //        ['code'=>'TSOCS'],
     //        [
     //             'name'=>'Transport Security Oversight and Compliance Service',
     //             'office_group'=> NULL
     //        ]
     //   );
     //   $division = Division::updateOrCreate(
     //        ['code'=>'CASD'],
     //        [
     //             'name'=>'Civil Aviation Security Division',
     //             'office_group'=> 1
     //        ]
     //   );
     //   $division = Division::updateOrCreate(
     //        ['code'=>'MTSD'],
     //        [
     //             'name'=>'Maritime Transport Security Division',
     //             'office_group'=> 1
     //        ]
     //   );
     //   $division = Division::updateOrCreate(
     //        ['code'=>'LTSD'],
     //        [
     //             'name'=>'Land Transport Security Division',
     //             'office_group'=> 1
     //        ]
     //   );
     //   $division = Division::updateOrCreate(
     //        ['code'=>'TSATMS'],
     //        [
     //             'name'=>'Transport Security Accreditation and Training Management Service',
     //             'office_group'=> NULL
     //        ]
     //   );
     //   $division = Division::updateOrCreate(
     //        ['code'=>'ACD'],
     //        [
     //             'name'=>'Accreditation and Certification Division',
     //             'office_group'=> 2
     //        ]
     //   );
     //   $division = Division::updateOrCreate(
     //        ['code'=>'TPDD'],
     //        [
     //             'name'=>'Training and Program Development Division',
     //             'office_group'=> 2
     //        ]
     //   );
          $division = Division::updateOrCreate(
               ['code'=>'LS'],
               [
                    'name'=>'Legal Service',
                    'office_group'=> NULL
               ]
          );
          Schema::enableForeignKeyConstraints();
    }
}
