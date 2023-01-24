<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\EmployeeGroup;
class EmployeeGroupSeeder extends Seeder
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
        EmployeeGroup::updateOrCreate([
            'code' => 'OTS Main Office'
        ],[
            'description' => 'OTS Main Office'
        ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'NAIA T1'
                ],[
                    'description' => 'NAIA T1'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'NAIA T2 SW'
                ],[
                    'description' => 'NAIA T2 SW'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'NAIA T2 NW'
                ],[
                    'description' => 'NAIA T2 NW'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'NAIA T3'
                ],[
                    'description' => 'NAIA T3'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'NAIA T4'
                ],[
                    'description' => 'NAIA T4'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Mactan-Cebu'
                ],[
                    'description' => 'Mactan-Cebu'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Davao'
                ],[
                    'description' => 'Davao'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Clark'
                ],[
                    'description' => 'Clark'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Iloilo'
                ],[
                    'description' => 'Iloilo'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Caticlan'
                ],[
                    'description' => 'Caticlan'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Kalibo'
                ],[
                    'description' => 'Kalibo'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Bohol-Panglao'
                ],[
                    'description' => 'Bohol-Panglao'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Laguindingan'
                ],[
                    'description' => 'Laguindingan'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Bacolod Silay'
                ],[
                    'description' => 'Bacolod Silay'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Puerto Princesa'
                ],[
                    'description' => 'Puerto Princesa'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'General Santos'
                ],[
                    'description' => 'General Santos'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Zamboanga'
                ],[
                    'description' => 'Zamboanga'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Butuan'
                ],[
                    'description' => 'Butuan'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Tacloban'
                ],[
                    'description' => 'Tacloban'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Naga'
                ],[
                    'description' => 'Naga'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Dipolog'
                ],[
                    'description' => 'Dipolog'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Tuguegarao'
                ],[
                    'description' => 'Tuguegarao'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Legazpi'
                ],[
                    'description' => 'Legazpi'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Siargao'
                ],[
                    'description' => 'Siargao'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Dumaguete'
                ],[
                    'description' => 'Dumaguete'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Laoag'
                ],[
                    'description' => 'Laoag'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Ozamiz'
                ],[
                    'description' => 'Ozamiz'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Roxas'
                ],[
                    'description' => 'Roxas'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Surigao'
                ],[
                    'description' => 'Surigao'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Pagadian'
                ],[
                    'description' => 'Pagadian'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Busuanga'
                ],[
                    'description' => 'Busuanga'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Camiguin'
                ],[
                    'description' => 'Camiguin'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Cotabato'
                ],[
                    'description' => 'Cotabato'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Subic'
                ],[
                    'description' => 'Subic'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Vigan'
                ],[
                    'description' => 'Vigan'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Cauayan'
                ],[
                    'description' => 'Cauayan'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Masbate'
                ],[
                    'description' => 'Masbate'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Calbayog'
                ],[
                    'description' => 'Calbayog'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Catarman'
                ],[
                    'description' => 'Catarman'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Marinduque'
                ],[
                    'description' => 'Marinduque'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Tablas'
                ],[
                    'description' => 'Tablas'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Tandag'
                ],[
                    'description' => 'Tandag'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Antique'
                ],[
                    'description' => 'Antique'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'San Jose, Mindoro'
                ],[
                    'description' => 'San Jose, Mindoro'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Sanga-Sanga'
                ],[
                    'description' => 'Sanga-Sanga'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Virac'
                ],[
                    'description' => 'Virac'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Basco, Batanes'
                ],[
                    'description' => 'Basco, Batanes'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'San Fernando, La Union'
                ],[
                    'description' => 'San Fernando, La Union'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Baguio'
                ],[
                    'description' => 'Baguio'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Sangley'
                ],[
                    'description' => 'Sangley'
                ]);
        EmployeeGroup::updateOrCreate([
                    'code' => 'Jolo'
                ],[
                    'description' => 'Jolo'
                ]);
        Schema::enableForeignKeyConstraints();
    }
}
