<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SalaryGrade;
use Illuminate\Support\Facades\Schema;

class SalaryGradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
         $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 1,
                'tranche' => 2,
                'step' => 1,                
            ],
            [
                'salary' => 12034
            ]
        );
        $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 1,
                'tranche' => 2,
                'step' => 2,                
            ],
            [
                'salary' => 12134
            ]
        );
        $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 1,
                'tranche' => 2,
                'step' => 3,                
            ],
            [
                'salary' => 12236
            ]
        );
        $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 1,
                'tranche' => 2,
                'step' => 4,                
            ],
            [
                'salary' => 12339
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 1,
                'tranche' => 2,
                'step' => 5,                
            ],
            [
                'salary' => 12442
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 1,
                'tranche' => 2,
                'step' => 6,                
            ],
            [
                'salary' => 12545
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 1,
                'tranche' => 2,
                'step' => 7,                
            ],
            [
                'salary' => 12651
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 1,
                'tranche' => 2,
                'step' => 8,                
            ],
            [
                'salary' => 12756
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 2,
                'tranche' => 2,
                'step' => 1,                
            ],
            [
                'salary' => 12790
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 2,
                'tranche' => 2,
                'step' => 2,                
            ],
            [
                'salary' => 12888
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 2,
                'tranche' => 2,
                'step' => 3,                
            ],
            [
                'salary' => 12987
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 2,
                'tranche' => 2,
                'step' => 4,                
            ],
            [
                'salary' => 13087
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 2,
                'tranche' => 2,
                'step' => 5,                
            ],
            [
                'salary' => 13187
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 2,
                'tranche' => 2,
                'step' => 6,                
            ],
            [
                'salary' => 13288
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 2,
                'tranche' => 2,
                'step' => 7,                
            ],
            [
                'salary' => 13390
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 2,
                'tranche' => 2,
                'step' => 8,                
            ],
            [
                'salary' => 13493
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 3,
                'tranche' => 2,
                'step' => 1,                
            ],
            [
                'salary' => 13572
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 3,
                'tranche' => 2,
                'step' => 2,                
            ],
            [
                'salary' => 13677
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 3,
                'tranche' => 2,
                'step' => 3,                
            ],
            [
                'salary' => 13781
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 3,
                'tranche' => 2,
                'step' => 4,                
            ],
            [
                'salary' => 13888
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 3,
                'tranche' => 2,
                'step' => 5,                
            ],
            [
                'salary' => 13995
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 3,
                'tranche' => 2,
                'step' => 6,                
            ],
            [
                'salary' => 14101
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 3,
                'tranche' => 2,
                'step' => 7,                
            ],
            [
                'salary' => 14210
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 3,
                'tranche' => 2,
                'step' => 8,                
            ],
            [
                'salary' => 14319
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 4,
                'tranche' => 2,
                'step' => 1,                
            ],
            [
                'salary' => 14400
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 4,
                'tranche' => 2,
                'step' => 2,                
            ],
            [
                'salary' => 14511
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 4,
                'tranche' => 2,
                'step' => 3,                
            ],
            [
                'salary' => 14622
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 4,
                'tranche' => 2,
                'step' => 4,                
            ],
            [
                'salary' => 14735
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 4,
                'tranche' => 2,
                'step' => 5,                
            ],
            [
                'salary' => 14848
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 4,
                'tranche' => 2,
                'step' => 6,                
            ],
            [
                'salary' => 14961
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 4,
                'tranche' => 2,
                'step' => 7,                
            ],
            [
                'salary' => 15077
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 4,
                'tranche' => 2,
                'step' => 8,                
            ],
            [
                'salary' => 15192
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 5,
                'tranche' => 2,
                'step' => 1,                
            ],
            [
                'salary' => 15275
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 5,
                'tranche' => 2,
                'step' => 2,                
            ],
            [
                'salary' => 15393
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 5,
                'tranche' => 2,
                'step' => 3,                
            ],
            [
                'salary' => 15511
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 5,
                'tranche' => 2,
                'step' => 4,                
            ],
            [
                'salary' => 15630
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 5,
                'tranche' => 2,
                'step' => 5,                
            ],
            [
                'salary' => 15750
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 5,
                'tranche' => 2,
                'step' => 6,                
            ],
            [
                'salary' => 15871
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 5,
                'tranche' => 2,
                'step' => 7,                
            ],
            [
                'salary' => 15993
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 5,
                'tranche' => 2,
                'step' => 8,                
            ],
            [
                'salary' => 16115
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 6,
                'tranche' => 2,
                'step' => 1,                
            ],
            [
                'salary' => 16200
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 6,
                'tranche' => 2,
                'step' => 2,                
            ],
            [
                'salary' => 16325
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 6,
                'tranche' => 2,
                'step' => 3,                
            ],
            [
                'salary' => 16450
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 6,
                'tranche' => 2,
                'step' => 4,                
            ],
            [
                'salary' => 16577
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 6,
                'tranche' => 2,
                'step' => 5,                
            ],
            [
                'salary' => 16704
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 6,
                'tranche' => 2,
                'step' => 6,                
            ],
            [
                'salary' => 16832
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 6,
                'tranche' => 2,
                'step' => 7,                
            ],
            [
                'salary' => 16962
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 6,
                'tranche' => 2,
                'step' => 8,                
            ],
            [
                'salary' => 17092
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 7,
                'tranche' => 2,
                'step' => 1,                
            ],
            [
                'salary' => 17179
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 7,
                'tranche' => 2,
                'step' => 2,                
            ],
            [
                'salary' => 17311
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 7,
                'tranche' => 2,
                'step' => 3,                
            ],
            [
                'salary' => 17444
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 7,
                'tranche' => 2,
                'step' => 4,                
            ],
            [
                'salary' => 17578
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 7,
                'tranche' => 2,
                'step' => 5,                
            ],
            [
                'salary' => 17713
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 7,
                'tranche' => 2,
                'step' => 6,                
            ],
            [
                'salary' => 17849
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 7,
                'tranche' => 2,
                'step' => 7,                
            ],
            [
                'salary' => 17985
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 7,
                'tranche' => 2,
                'step' => 8,                
            ],
            [
                'salary' => 18124
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 8,
                'tranche' => 2,
                'step' => 1,                
            ],
            [
                'salary' => 18251
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 8,
                'tranche' => 2,
                'step' => 2,                
            ],
            [
                'salary' => 18417
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 8,
                'tranche' => 2,
                'step' => 3,                
            ],
            [
                'salary' => 18583
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 8,
                'tranche' => 2,
                'step' => 4,                
            ],
            [
                'salary' => 18751
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 8,
                'tranche' => 2,
                'step' => 5,                
            ],
            [
                'salary' => 18920
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 8,
                'tranche' => 2,
                'step' => 6,                
            ],
            [
                'salary' => 19091
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 8,
                'tranche' => 2,
                'step' => 7,                
            ],
            [
                'salary' => 19264
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 8,
                'tranche' => 2,
                'step' => 8,                
            ],
            [
                'salary' => 19438
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 9,
                'tranche' => 2,
                'step' => 1,                
            ],
            [
                'salary' => 19552
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 9,
                'tranche' => 2,
                'step' => 2,                
            ],
            [
                'salary' => 19715
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 9,
                'tranche' => 2,
                'step' => 3,                
            ],
            [
                'salary' => 19880
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 9,
                'tranche' => 2,
                'step' => 4,                
            ],
            [
                'salary' => 20046
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 9,
                'tranche' => 2,
                'step' => 5,                
            ],
            [
                'salary' => 20214
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 9,
                'tranche' => 2,
                'step' => 6,                
            ],
            [
                'salary' => 20382
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 9,
                'tranche' => 2,
                'step' => 7,                
            ],
            [
                'salary' => 20553
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 9,
                'tranche' => 2,
                'step' => 8,                
            ],
            [
                'salary' => 20725
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 10,
                'tranche' => 2,
                'step' => 1,                
            ],
            [
                'salary' => 21205
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 10,
                'tranche' => 2,
                'step' => 2,                
            ],
            [
                'salary' => 21382
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 10,
                'tranche' => 2,
                'step' => 3,                
            ],
            [
                'salary' => 21561
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 10,
                'tranche' => 2,
                'step' => 4,                
            ],
            [
                'salary' => 21741
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 10,
                'tranche' => 2,
                'step' => 5,                
            ],
            [
                'salary' => 21923
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 10,
                'tranche' => 2,
                'step' => 6,                
            ],
            [
                'salary' => 22106
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 10,
                'tranche' => 2,
                'step' => 7,                
            ],
            [
                'salary' => 22291
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 10,
                'tranche' => 2,
                'step' => 8,                
            ],
            [
                'salary' => 22477
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 11,
                'tranche' => 2,
                'step' => 1,                
            ],
            [
                'salary' => 23877
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 11,
                'tranche' => 2,
                'step' => 2,                
            ],
            [
                'salary' => 24161
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 11,
                'tranche' => 2,
                'step' => 3,                
            ],
            [
                'salary' => 24450
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 11,
                'tranche' => 2,
                'step' => 4,                
            ],
            [
                'salary' => 24742
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 11,
                'tranche' => 2,
                'step' => 5,                
            ],
            [
                'salary' => 25038
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 11,
                'tranche' => 2,
                'step' => 6,                
            ],
            [
                'salary' => 25339
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 11,
                'tranche' => 2,
                'step' => 7,                
            ],
            [
                'salary' => 25643
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 11,
                'tranche' => 2,
                'step' => 8,                
            ],
            [
                'salary' => 25952
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 12,
                'tranche' => 2,
                'step' => 1,                
            ],
            [
                'salary' => 26052
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 12,
                'tranche' => 2,
                'step' => 2,                
            ],
            [
                'salary' => 26336
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 12,
                'tranche' => 2,
                'step' => 3,                
            ],
            [
                'salary' => 26624
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 12,
                'tranche' => 2,
                'step' => 4,                
            ],
            [
                'salary' => 26915
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 12,
                'tranche' => 2,
                'step' => 5,                
            ],
            [
                'salary' => 27210
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 12,
                'tranche' => 2,
                'step' => 6,                
            ],
            [
                'salary' => 27509
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 12,
                'tranche' => 2,
                'step' => 7,                
            ],
            [
                'salary' => 27811
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 12,
                'tranche' => 2,
                'step' => 8,                
            ],
            [
                'salary' => 28117
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 13,
                'tranche' => 2,
                'step' => 1,                
            ],
            [
                'salary' => 28276
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 13,
                'tranche' => 2,
                'step' => 2,                
            ],
            [
                'salary' => 28589
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 13,
                'tranche' => 2,
                'step' => 3,                
            ],
            [
                'salary' => 28905
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 13,
                'tranche' => 2,
                'step' => 4,                
            ],
            [
                'salary' => 29225
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 13,
                'tranche' => 2,
                'step' => 5,                
            ],
            [
                'salary' => 29550
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 13,
                'tranche' => 2,
                'step' => 6,                
            ],
            [
                'salary' => 29878
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 13,
                'tranche' => 2,
                'step' => 7,                
            ],
            [
                'salary' => 30210
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 13,
                'tranche' => 2,
                'step' => 8,                
            ],
            [
                'salary' => 30547
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 14,
                'tranche' => 2,
                'step' => 1,                
            ],
            [
                'salary' => 30799
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 14,
                'tranche' => 2,
                'step' => 2,                
            ],
            [
                'salary' => 31143
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 14,
                'tranche' => 2,
                'step' => 3,                
            ],
            [
                'salary' => 31491
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 14,
                'tranche' => 2,
                'step' => 4,                
            ],
            [
                'salary' => 31844
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 14,
                'tranche' => 2,
                'step' => 5,                
            ],
            [
                'salary' => 32200
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 14,
                'tranche' => 2,
                'step' => 6,                
            ],
            [
                'salary' => 32561
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 14,
                'tranche' => 2,
                'step' => 7,                
            ],
            [
                'salary' => 32927
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 14,
                'tranche' => 2,
                'step' => 8,                
            ],
            [
                'salary' => 33297
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 15,
                'tranche' => 2,
                'step' => 1,                
            ],
            [
                'salary' => 33575
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 15,
                'tranche' => 2,
                'step' => 2,                
            ],
            [
                'salary' => 33953
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 15,
                'tranche' => 2,
                'step' => 3,                
            ],
            [
                'salary' => 34336
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 15,
                'tranche' => 2,
                'step' => 4,                
            ],
            [
                'salary' => 34724
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 15,
                'tranche' => 2,
                'step' => 5,                
            ],
            [
                'salary' => 35116
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 15,
                'tranche' => 2,
                'step' => 6,                
            ],
            [
                'salary' => 35513
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 15,
                'tranche' => 2,
                'step' => 7,                
            ],
            [
                'salary' => 35915
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 15,
                'tranche' => 2,
                'step' => 8,                
            ],
            [
                'salary' => 36323
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 16,
                'tranche' => 2,
                'step' => 1,                
            ],
            [
                'salary' => 36628
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 16,
                'tranche' => 2,
                'step' => 2,                
            ],
            [
                'salary' => 37044
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 16,
                'tranche' => 2,
                'step' => 3,                
            ],
            [
                'salary' => 37465
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 16,
                'tranche' => 2,
                'step' => 4,                
            ],
            [
                'salary' => 37891
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 16,
                'tranche' => 2,
                'step' => 5,                
            ],
            [
                'salary' => 38323
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 16,
                'tranche' => 2,
                'step' => 6,                
            ],
            [
                'salary' => 38760
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 16,
                'tranche' => 2,
                'step' => 7,                
            ],
            [
                'salary' => 39203
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 16,
                'tranche' => 2,
                'step' => 8,                
            ],
            [
                'salary' => 39650
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 17,
                'tranche' => 2,
                'step' => 1,                
            ],
            [
                'salary' => 39986
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 17,
                'tranche' => 2,
                'step' => 2,                
            ],
            [
                'salary' => 40444
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 17,
                'tranche' => 2,
                'step' => 3,                
            ],
            [
                'salary' => 40907
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 17,
                'tranche' => 2,
                'step' => 4,                
            ],
            [
                'salary' => 41376
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 17,
                'tranche' => 2,
                'step' => 5,                
            ],
            [
                'salary' => 41851
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 17,
                'tranche' => 2,
                'step' => 6,                
            ],
            [
                'salary' => 42332
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 17,
                'tranche' => 2,
                'step' => 7,                
            ],
            [
                'salary' => 42818
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 17,
                'tranche' => 2,
                'step' => 8,                
            ],
            [
                'salary' => 43311
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 18,
                'tranche' => 2,
                'step' => 1,                
            ],
            [
                'salary' => 43681
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 18,
                'tranche' => 2,
                'step' => 2,                
            ],
            [
                'salary' => 44184
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 18,
                'tranche' => 2,
                'step' => 3,                
            ],
            [
                'salary' => 44694
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 18,
                'tranche' => 2,
                'step' => 4,                
            ],
            [
                'salary' => 45209
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 18,
                'tranche' => 2,
                'step' => 5,                
            ],
            [
                'salary' => 45732
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 18,
                'tranche' => 2,
                'step' => 6,                
            ],
            [
                'salary' => 46261
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 18,
                'tranche' => 2,
                'step' => 7,                
            ],
            [
                'salary' => 46796
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 18,
                'tranche' => 2,
                'step' => 8,                
            ],
            [
                'salary' => 47338
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 19,
                'tranche' => 2,
                'step' => 1,                
            ],
            [
                'salary' => 48313
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 19,
                'tranche' => 2,
                'step' => 2,                
            ],
            [
                'salary' => 49052
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 19,
                'tranche' => 2,
                'step' => 3,                
            ],
            [
                'salary' => 49803
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 19,
                'tranche' => 2,
                'step' => 4,                
            ],
            [
                'salary' => 50566
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 19,
                'tranche' => 2,
                'step' => 5,                
            ],
            [
                'salary' => 51342
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 19,
                'tranche' => 2,
                'step' => 6,                
            ],
            [
                'salary' => 52130
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 19,
                'tranche' => 2,
                'step' => 7,                
            ],
            [
                'salary' => 52932
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 19,
                'tranche' => 2,
                'step' => 8,                
            ],
            [
                'salary' => 53746
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 20,
                'tranche' => 2,
                'step' => 1,                
            ],
            [
                'salary' => 54251
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 20,
                'tranche' => 2,
                'step' => 2,                
            ],
            [
                'salary' => 55085
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 20,
                'tranche' => 2,
                'step' => 3,                
            ],
            [
                'salary' => 55934
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 20,
                'tranche' => 2,
                'step' => 4,                
            ],
            [
                'salary' => 56796
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 20,
                'tranche' => 2,
                'step' => 5,                
            ],
            [
                'salary' => 57673
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 20,
                'tranche' => 2,
                'step' => 6,                
            ],
            [
                'salary' => 58564
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 20,
                'tranche' => 2,
                'step' => 7,                
            ],
            [
                'salary' => 59469
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 20,
                'tranche' => 2,
                'step' => 8,                
            ],
            [
                'salary' => 60389
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 21,
                'tranche' => 2,
                'step' => 1,                
            ],
            [
                'salary' => 60901
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 21,
                'tranche' => 2,
                'step' => 2,                
            ],
            [
                'salary' => 61844
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 21,
                'tranche' => 2,
                'step' => 3,                
            ],
            [
                'salary' => 62803
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 21,
                'tranche' => 2,
                'step' => 4,                
            ],
            [
                'salary' => 63777
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 21,
                'tranche' => 2,
                'step' => 5,                
            ],
            [
                'salary' => 64768
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 21,
                'tranche' => 2,
                'step' => 6,                
            ],
            [
                'salary' => 65774
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 21,
                'tranche' => 2,
                'step' => 7,                
            ],
            [
                'salary' => 66797
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 21,
                'tranche' => 2,
                'step' => 8,                
            ],
            [
                'salary' => 67837
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 22,
                'tranche' => 2,
                'step' => 1,                
            ],
            [
                'salary' => 68415
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 22,
                'tranche' => 2,
                'step' => 2,                
            ],
            [
                'salary' => 69481
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 22,
                'tranche' => 2,
                'step' => 3,                
            ],
            [
                'salary' => 70565
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 22,
                'tranche' => 2,
                'step' => 4,                
            ],
            [
                'salary' => 71666
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 22,
                'tranche' => 2,
                'step' => 5,                
            ],
            [
                'salary' => 72785
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 22,
                'tranche' => 2,
                'step' => 6,                
            ],
            [
                'salary' => 73923
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 22,
                'tranche' => 2,
                'step' => 7,                
            ],
            [
                'salary' => 75079
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 22,
                'tranche' => 2,
                'step' => 8,                
            ],
            [
                'salary' => 76253
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 23,
                'tranche' => 2,
                'step' => 1,                
            ],
            [
                'salary' => 76907
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 23,
                'tranche' => 2,
                'step' => 2,                
            ],
            [
                'salary' => 78111
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 23,
                'tranche' => 2,
                'step' => 3,                
            ],
            [
                'salary' => 79336
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 23,
                'tranche' => 2,
                'step' => 4,                
            ],
            [
                'salary' => 80583
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 23,
                'tranche' => 2,
                'step' => 5,                
            ],
            [
                'salary' => 81899
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 23,
                'tranche' => 2,
                'step' => 6,                
            ],
            [
                'salary' => 83235
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 23,
                'tranche' => 2,
                'step' => 7,                
            ],
            [
                'salary' => 84594
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 23,
                'tranche' => 2,
                'step' => 8,                
            ],
            [
                'salary' => 85975
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 24,
                'tranche' => 2,
                'step' => 1,                
            ],
            [
                'salary' => 86742
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 24,
                'tranche' => 2,
                'step' => 2,                
            ],
            [
                'salary' => 88158
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 24,
                'tranche' => 2,
                'step' => 3,                
            ],
            [
                'salary' => 89597
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 24,
                'tranche' => 2,
                'step' => 4,                
            ],
            [
                'salary' => 91059
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 24,
                'tranche' => 2,
                'step' => 5,                
            ],
            [
                'salary' => 92545
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 24,
                'tranche' => 2,
                'step' => 6,                
            ],
            [
                'salary' => 94057
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 24,
                'tranche' => 2,
                'step' => 7,                
            ],
            [
                'salary' => 95592
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 24,
                'tranche' => 2,
                'step' => 8,                
            ],
            [
                'salary' => 97152
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 25,
                'tranche' => 2,
                'step' => 1,                
            ],
            [
                'salary' => 98886
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 25,
                'tranche' => 2,
                'step' => 2,                
            ],
            [
                'salary' => 100500
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 25,
                'tranche' => 2,
                'step' => 3,                
            ],
            [
                'salary' => 102140
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 25,
                'tranche' => 2,
                'step' => 4,                
            ],
            [
                'salary' => 103808
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 25,
                'tranche' => 2,
                'step' => 5,                
            ],
            [
                'salary' => 105502
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 25,
                'tranche' => 2,
                'step' => 6,                
            ],
            [
                'salary' => 107224
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 25,
                'tranche' => 2,
                'step' => 7,                
            ],
            [
                'salary' => 108974
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 25,
                'tranche' => 2,
                'step' => 8,                
            ],
            [
                'salary' => 110753
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 26,
                'tranche' => 2,
                'step' => 1,                
            ],
            [
                'salary' => 111742
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 26,
                'tranche' => 2,
                'step' => 2,                
            ],
            [
                'salary' => 113565
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 26,
                'tranche' => 2,
                'step' => 3,                
            ],
            [
                'salary' => 115419
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 26,
                'tranche' => 2,
                'step' => 4,                
            ],
            [
                'salary' => 117303
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 26,
                'tranche' => 2,
                'step' => 5,                
            ],
            [
                'salary' => 119217
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 26,
                'tranche' => 2,
                'step' => 6,                
            ],
            [
                'salary' => 121163
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 26,
                'tranche' => 2,
                'step' => 7,                
            ],
            [
                'salary' => 123140
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 26,
                'tranche' => 2,
                'step' => 8,                
            ],
            [
                'salary' => 125150
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 27,
                'tranche' => 2,
                'step' => 1,                
            ],
            [
                'salary' => 126267
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 27,
                'tranche' => 2,
                'step' => 2,                
            ],
            [
                'salary' => 128329
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 27,
                'tranche' => 2,
                'step' => 3,                
            ],
            [
                'salary' => 130423
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 27,
                'tranche' => 2,
                'step' => 4,                
            ],
            [
                'salary' => 132552
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 27,
                'tranche' => 2,
                'step' => 5,                
            ],
            [
                'salary' => 134715
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 27,
                'tranche' => 2,
                'step' => 6,                
            ],
            [
                'salary' => 136914
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 27,
                'tranche' => 2,
                'step' => 7,                
            ],
            [
                'salary' => 139149
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 27,
                'tranche' => 2,
                'step' => 8,                
            ],
            [
                'salary' => 141420
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 28,
                'tranche' => 2,
                'step' => 1,                
            ],
            [
                'salary' => 142683
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 28,
                'tranche' => 2,
                'step' => 2,                
            ],
            [
                'salary' => 145011
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 28,
                'tranche' => 2,
                'step' => 3,                
            ],
            [
                'salary' => 147378
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 28,
                'tranche' => 2,
                'step' => 4,                
            ],
            [
                'salary' => 149784
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 28,
                'tranche' => 2,
                'step' => 5,                
            ],
            [
                'salary' => 152228
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 28,
                'tranche' => 2,
                'step' => 6,                
            ],
            [
                'salary' => 154714
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 28,
                'tranche' => 2,
                'step' => 7,                
            ],
            [
                'salary' => 157239
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 28,
                'tranche' => 2,
                'step' => 8,                
            ],
            [
                'salary' => 159804
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 29,
                'tranche' => 2,
                'step' => 1,                
            ],
            [
                'salary' => 161231
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 29,
                'tranche' => 2,
                'step' => 2,                
            ],
            [
                'salary' => 163863
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 29,
                'tranche' => 2,
                'step' => 3,                
            ],
            [
                'salary' => 166537
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 29,
                'tranche' => 2,
                'step' => 4,                
            ],
            [
                'salary' => 169256
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 29,
                'tranche' => 2,
                'step' => 5,                
            ],
            [
                'salary' => 172018
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 29,
                'tranche' => 2,
                'step' => 6,                
            ],
            [
                'salary' => 174826
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 29,
                'tranche' => 2,
                'step' => 7,                
            ],
            [
                'salary' => 177679
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 29,
                'tranche' => 2,
                'step' => 8,                
            ],
            [
                'salary' => 180579
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 30,
                'tranche' => 2,
                'step' => 1,                
            ],
            [
                'salary' => 182191
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 30,
                'tranche' => 2,
                'step' => 2,                
            ],
            [
                'salary' => 185165
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 30,
                'tranche' => 2,
                'step' => 3,                
            ],
            [
                'salary' => 188187
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 30,
                'tranche' => 2,
                'step' => 4,                
            ],
            [
                'salary' => 191259
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 30,
                'tranche' => 2,
                'step' => 5,                
            ],
            [
                'salary' => 194380
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 30,
                'tranche' => 2,
                'step' => 6,                
            ],
            [
                'salary' => 197553
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 30,
                'tranche' => 2,
                'step' => 7,                
            ],
            [
                'salary' => 200777
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 30,
                'tranche' => 2,
                'step' => 8,                
            ],
            [
                'salary' => 204054
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 31,
                'tranche' => 2,
                'step' => 1,                
            ],
            [
                'salary' => 268121
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 31,
                'tranche' => 2,
                'step' => 2,                
            ],
            [
                'salary' => 273358
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 31,
                'tranche' => 2,
                'step' => 3,                
            ],
            [
                'salary' => 278697
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 31,
                'tranche' => 2,
                'step' => 4,                
            ],
            [
                'salary' => 284140
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 31,
                'tranche' => 2,
                'step' => 5,                
            ],
            [
                'salary' => 289691
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 31,
                'tranche' => 2,
                'step' => 6,                
            ],
            [
                'salary' => 295349
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 31,
                'tranche' => 2,
                'step' => 7,                
            ],
            [
                'salary' => 301117
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 31,
                'tranche' => 2,
                'step' => 8,                
            ],
            [
                'salary' => 306999
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 32,
                'tranche' => 2,
                'step' => 1,                
            ],
            [
                'salary' => 319660
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 32,
                'tranche' => 2,
                'step' => 2,                
            ],
            [
                'salary' => 326107
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 32,
                'tranche' => 2,
                'step' => 3,                
            ],
            [
                'salary' => 332682
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 32,
                'tranche' => 2,
                'step' => 4,                
            ],
            [
                'salary' => 339392
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 32,
                'tranche' => 2,
                'step' => 5,                
            ],
            [
                'salary' => 346236
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 32,
                'tranche' => 2,
                'step' => 6,                
            ],
            [
                'salary' => 353218
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 32,
                'tranche' => 2,
                'step' => 7,                
            ],
            [
                'salary' => 360342
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 32,
                'tranche' => 2,
                'step' => 8,                
            ],
            [
                'salary' => 367609
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 33,
                'tranche' => 2,
                'step' => 1,                
            ],
            [
                'salary' => 403620
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 33,
                'tranche' => 2,
                'step' => 2,                
            ],
            [
                'salary' => 415728
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 1,
                'tranche' => 3,
                'step' => 1,                
            ],
            [
                'salary' => 12517
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 1,
                'tranche' => 3,
                'step' => 2,                
            ],
            [
                'salary' => 12621
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 1,
                'tranche' => 3,
                'step' => 3,                
            ],
            [
                'salary' => 12728
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 1,
                'tranche' => 3,
                'step' => 4,                
            ],
            [
                'salary' => 12834
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 1,
                'tranche' => 3,
                'step' => 5,                
            ],
            [
                'salary' => 12941
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 1,
                'tranche' => 3,
                'step' => 6,                
            ],
            [
                'salary' => 13049
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 1,
                'tranche' => 3,
                'step' => 7,                
            ],
            [
                'salary' => 13159
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 1,
                'tranche' => 3,
                'step' => 8,                
            ],
            [
                'salary' => 13268
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 2,
                'tranche' => 3,
                'step' => 1,                
            ],
            [
                'salary' => 13305
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 2,
                'tranche' => 3,
                'step' => 2,                
            ],
            [
                'salary' => 13406
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 2,
                'tranche' => 3,
                'step' => 3,                
            ],
            [
                'salary' => 13509
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 2,
                'tranche' => 3,
                'step' => 4,                
            ],
            [
                'salary' => 13613
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 2,
                'tranche' => 3,
                'step' => 5,                
            ],
            [
                'salary' => 13718
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 2,
                'tranche' => 3,
                'step' => 6,                
            ],
            [
                'salary' => 13823
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 2,
                'tranche' => 3,
                'step' => 7,                
            ],
            [
                'salary' => 13929
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 2,
                'tranche' => 3,
                'step' => 8,                
            ],
            [
                'salary' => 14035
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 3,
                'tranche' => 3,
                'step' => 1,                
            ],
            [
                'salary' => 14125
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 3,
                'tranche' => 3,
                'step' => 2,                
            ],
            [
                'salary' => 14234
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 3,
                'tranche' => 3,
                'step' => 3,                
            ],
            [
                'salary' => 14343
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 3,
                'tranche' => 3,
                'step' => 4,                
            ],
            [
                'salary' => 14454
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 3,
                'tranche' => 3,
                'step' => 5,                
            ],
            [
                'salary' => 14565
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 3,
                'tranche' => 3,
                'step' => 6,                
            ],
            [
                'salary' => 14676
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 3,
                'tranche' => 3,
                'step' => 7,                
            ],
            [
                'salary' => 14790
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 3,
                'tranche' => 3,
                'step' => 8,                
            ],
            [
                'salary' => 14903
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 4,
                'tranche' => 3,
                'step' => 1,                
            ],
            [
                'salary' => 14993
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 4,
                'tranche' => 3,
                'step' => 2,                
            ],
            [
                'salary' => 15109
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 4,
                'tranche' => 3,
                'step' => 3,                
            ],
            [
                'salary' => 15224
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 4,
                'tranche' => 3,
                'step' => 4,                
            ],
            [
                'salary' => 15341
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 4,
                'tranche' => 3,
                'step' => 5,                
            ],
            [
                'salary' => 15459
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 4,
                'tranche' => 3,
                'step' => 6,                
            ],
            [
                'salary' => 15577
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 4,
                'tranche' => 3,
                'step' => 7,                
            ],
            [
                'salary' => 15698
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 4,
                'tranche' => 3,
                'step' => 8,                
            ],
            [
                'salary' => 15818
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 5,
                'tranche' => 3,
                'step' => 1,                
            ],
            [
                'salary' => 15909
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 5,
                'tranche' => 3,
                'step' => 2,                
            ],
            [
                'salary' => 16032
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 5,
                'tranche' => 3,
                'step' => 3,                
            ],
            [
                'salary' => 16155
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 5,
                'tranche' => 3,
                'step' => 4,                
            ],
            [
                'salary' => 16279
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 5,
                'tranche' => 3,
                'step' => 5,                
            ],
            [
                'salary' => 16404
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 5,
                'tranche' => 3,
                'step' => 6,                
            ],
            [
                'salary' => 16530
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 5,
                'tranche' => 3,
                'step' => 7,                
            ],
            [
                'salary' => 16657
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 5,
                'tranche' => 3,
                'step' => 8,                
            ],
            [
                'salary' => 16784
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 6,
                'tranche' => 3,
                'step' => 1,                
            ],
            [
                'salary' => 16877
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 6,
                'tranche' => 3,
                'step' => 2,                
            ],
            [
                'salary' => 17007
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 6,
                'tranche' => 3,
                'step' => 3,                
            ],
            [
                'salary' => 17137
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 6,
                'tranche' => 3,
                'step' => 4,                
            ],
            [
                'salary' => 17269
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 6,
                'tranche' => 3,
                'step' => 5,                
            ],
            [
                'salary' => 17402
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 6,
                'tranche' => 3,
                'step' => 6,                
            ],
            [
                'salary' => 17535
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 6,
                'tranche' => 3,
                'step' => 7,                
            ],
            [
                'salary' => 17670
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 6,
                'tranche' => 3,
                'step' => 8,                
            ],
            [
                'salary' => 17806
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 7,
                'tranche' => 3,
                'step' => 1,                
            ],
            [
                'salary' => 17899
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 7,
                'tranche' => 3,
                'step' => 2,                
            ],
            [
                'salary' => 18037
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 7,
                'tranche' => 3,
                'step' => 3,                
            ],
            [
                'salary' => 18176
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 7,
                'tranche' => 3,
                'step' => 4,                
            ],
            [
                'salary' => 18315
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 7,
                'tranche' => 3,
                'step' => 5,                
            ],
            [
                'salary' => 18455
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 7,
                'tranche' => 3,
                'step' => 6,                
            ],
            [
                'salary' => 18598
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 7,
                'tranche' => 3,
                'step' => 7,                
            ],
            [
                'salary' => 18740
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 7,
                'tranche' => 3,
                'step' => 8,                
            ],
            [
                'salary' => 18884
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 8,
                'tranche' => 3,
                'step' => 1,                
            ],
            [
                'salary' => 18998
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 8,
                'tranche' => 3,
                'step' => 2,                
            ],
            [
                'salary' => 19170
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 8,
                'tranche' => 3,
                'step' => 3,                
            ],
            [
                'salary' => 19343
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 8,
                'tranche' => 3,
                'step' => 4,                
            ],
            [
                'salary' => 19518
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 8,
                'tranche' => 3,
                'step' => 5,                
            ],
            [
                'salary' => 19694
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 8,
                'tranche' => 3,
                'step' => 6,                
            ],
            [
                'salary' => 19872
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 8,
                'tranche' => 3,
                'step' => 7,                
            ],
            [
                'salary' => 20052
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 8,
                'tranche' => 3,
                'step' => 8,                
            ],
            [
                'salary' => 20233
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 9,
                'tranche' => 3,
                'step' => 1,                
            ],
            [
                'salary' => 20340
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 9,
                'tranche' => 3,
                'step' => 2,                
            ],
            [
                'salary' => 20509
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 9,
                'tranche' => 3,
                'step' => 3,                
            ],
            [
                'salary' => 20681
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 9,
                'tranche' => 3,
                'step' => 4,                
            ],
            [
                'salary' => 20854
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 9,
                'tranche' => 3,
                'step' => 5,                
            ],
            [
                'salary' => 21029
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 9,
                'tranche' => 3,
                'step' => 6,                
            ],
            [
                'salary' => 21204
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 9,
                'tranche' => 3,
                'step' => 7,                
            ],
            [
                'salary' => 21382
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 9,
                'tranche' => 3,
                'step' => 8,                
            ],
            [
                'salary' => 21561
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 10,
                'tranche' => 3,
                'step' => 1,                
            ],
            [
                'salary' => 22190
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 10,
                'tranche' => 3,
                'step' => 2,                
            ],
            [
                'salary' => 22376
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 10,
                'tranche' => 3,
                'step' => 3,                
            ],
            [
                'salary' => 22563
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 10,
                'tranche' => 3,
                'step' => 4,                
            ],
            [
                'salary' => 22752
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 10,
                'tranche' => 3,
                'step' => 5,                
            ],
            [
                'salary' => 22942
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 10,
                'tranche' => 3,
                'step' => 6,                
            ],
            [
                'salary' => 23134
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 10,
                'tranche' => 3,
                'step' => 7,                
            ],
            [
                'salary' => 23327
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 10,
                'tranche' => 3,
                'step' => 8,                
            ],
            [
                'salary' => 23522
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 11,
                'tranche' => 3,
                'step' => 1,                
            ],
            [
                'salary' => 25439
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 11,
                'tranche' => 3,
                'step' => 2,                
            ],
            [
                'salary' => 25723
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 11,
                'tranche' => 3,
                'step' => 3,                
            ],
            [
                'salary' => 26012
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 11,
                'tranche' => 3,
                'step' => 4,                
            ],
            [
                'salary' => 26304
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 11,
                'tranche' => 3,
                'step' => 5,                
            ],
            [
                'salary' => 26600
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 11,
                'tranche' => 3,
                'step' => 6,                
            ],
            [
                'salary' => 26901
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 11,
                'tranche' => 3,
                'step' => 7,                
            ],
            [
                'salary' => 27205
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 11,
                'tranche' => 3,
                'step' => 8,                
            ],
            [
                'salary' => 27514
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 12,
                'tranche' => 3,
                'step' => 1,                
            ],
            [
                'salary' => 27608
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 12,
                'tranche' => 3,
                'step' => 2,                
            ],
            [
                'salary' => 27892
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 12,
                'tranche' => 3,
                'step' => 3,                
            ],
            [
                'salary' => 28180
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 12,
                'tranche' => 3,
                'step' => 4,                
            ],
            [
                'salary' => 28471
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 12,
                'tranche' => 3,
                'step' => 5,                
            ],
            [
                'salary' => 28766
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 12,
                'tranche' => 3,
                'step' => 6,                
            ],
            [
                'salary' => 29065
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 12,
                'tranche' => 3,
                'step' => 7,                
            ],
            [
                'salary' => 29367
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 12,
                'tranche' => 3,
                'step' => 8,                
            ],
            [
                'salary' => 29673
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 13,
                'tranche' => 3,
                'step' => 1,                
            ],
            [
                'salary' => 29798
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 13,
                'tranche' => 3,
                'step' => 2,                
            ],
            [
                'salary' => 30111
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 13,
                'tranche' => 3,
                'step' => 3,                
            ],
            [
                'salary' => 30427
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 13,
                'tranche' => 3,
                'step' => 4,                
            ],
            [
                'salary' => 30747
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 13,
                'tranche' => 3,
                'step' => 5,                
            ],
            [
                'salary' => 31072
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 13,
                'tranche' => 3,
                'step' => 6,                
            ],
            [
                'salary' => 31400
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 13,
                'tranche' => 3,
                'step' => 7,                
            ],
            [
                'salary' => 31732
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 13,
                'tranche' => 3,
                'step' => 8,                
            ],
            [
                'salary' => 32069
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 14,
                'tranche' => 3,
                'step' => 1,                
            ],
            [
                'salary' => 32321
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 14,
                'tranche' => 3,
                'step' => 2,                
            ],
            [
                'salary' => 32665
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 14,
                'tranche' => 3,
                'step' => 3,                
            ],
            [
                'salary' => 33013
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 14,
                'tranche' => 3,
                'step' => 4,                
            ],
            [
                'salary' => 33366
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 14,
                'tranche' => 3,
                'step' => 5,                
            ],
            [
                'salary' => 33722
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 14,
                'tranche' => 3,
                'step' => 6,                
            ],
            [
                'salary' => 34083
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 14,
                'tranche' => 3,
                'step' => 7,                
            ],
            [
                'salary' => 34449
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 14,
                'tranche' => 3,
                'step' => 8,                
            ],
            [
                'salary' => 34819
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 15,
                'tranche' => 3,
                'step' => 1,                
            ],
            [
                'salary' => 35097
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 15,
                'tranche' => 3,
                'step' => 2,                
            ],
            [
                'salary' => 35475
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 15,
                'tranche' => 3,
                'step' => 3,                
            ],
            [
                'salary' => 35858
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 15,
                'tranche' => 3,
                'step' => 4,                
            ],
            [
                'salary' => 36246
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 15,
                'tranche' => 3,
                'step' => 5,                
            ],
            [
                'salary' => 36638
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 15,
                'tranche' => 3,
                'step' => 6,                
            ],
            [
                'salary' => 37035
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 15,
                'tranche' => 3,
                'step' => 7,                
            ],
            [
                'salary' => 37437
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 15,
                'tranche' => 3,
                'step' => 8,                
            ],
            [
                'salary' => 37845
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 16,
                'tranche' => 3,
                'step' => 1,                
            ],
            [
                'salary' => 38150
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 16,
                'tranche' => 3,
                'step' => 2,                
            ],
            [
                'salary' => 38566
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 16,
                'tranche' => 3,
                'step' => 3,                
            ],
            [
                'salary' => 38987
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 16,
                'tranche' => 3,
                'step' => 4,                
            ],
            [
                'salary' => 39413
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 16,
                'tranche' => 3,
                'step' => 5,                
            ],
            [
                'salary' => 39845
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 16,
                'tranche' => 3,
                'step' => 6,                
            ],
            [
                'salary' => 40282
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 16,
                'tranche' => 3,
                'step' => 7,                
            ],
            [
                'salary' => 40725
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 16,
                'tranche' => 3,
                'step' => 8,                
            ],
            [
                'salary' => 41172
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 17,
                'tranche' => 3,
                'step' => 1,                
            ],
            [
                'salary' => 41508
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 17,
                'tranche' => 3,
                'step' => 2,                
            ],
            [
                'salary' => 41966
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 17,
                'tranche' => 3,
                'step' => 3,                
            ],
            [
                'salary' => 42429
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 17,
                'tranche' => 3,
                'step' => 4,                
            ],
            [
                'salary' => 42898
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 17,
                'tranche' => 3,
                'step' => 5,                
            ],
            [
                'salary' => 43373
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 17,
                'tranche' => 3,
                'step' => 6,                
            ],
            [
                'salary' => 43854
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 17,
                'tranche' => 3,
                'step' => 7,                
            ],
            [
                'salary' => 44340
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 17,
                'tranche' => 3,
                'step' => 8,                
            ],
            [
                'salary' => 44833
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 18,
                'tranche' => 3,
                'step' => 1,                
            ],
            [
                'salary' => 45203
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 18,
                'tranche' => 3,
                'step' => 2,                
            ],
            [
                'salary' => 45706
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 18,
                'tranche' => 3,
                'step' => 3,                
            ],
            [
                'salary' => 46216
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 18,
                'tranche' => 3,
                'step' => 4,                
            ],
            [
                'salary' => 46731
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 18,
                'tranche' => 3,
                'step' => 5,                
            ],
            [
                'salary' => 47254
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 18,
                'tranche' => 3,
                'step' => 6,                
            ],
            [
                'salary' => 47783
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 18,
                'tranche' => 3,
                'step' => 7,                
            ],
            [
                'salary' => 48318
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 18,
                'tranche' => 3,
                'step' => 8,                
            ],
            [
                'salary' => 48860
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 19,
                'tranche' => 3,
                'step' => 1,                
            ],
            [
                'salary' => 49835
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 19,
                'tranche' => 3,
                'step' => 2,                
            ],
            [
                'salary' => 50574
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 19,
                'tranche' => 3,
                'step' => 3,                
            ],
            [
                'salary' => 51325
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 19,
                'tranche' => 3,
                'step' => 4,                
            ],
            [
                'salary' => 52088
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 19,
                'tranche' => 3,
                'step' => 5,                
            ],
            [
                'salary' => 52864
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 19,
                'tranche' => 3,
                'step' => 6,                
            ],
            [
                'salary' => 53652
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 19,
                'tranche' => 3,
                'step' => 7,                
            ],
            [
                'salary' => 54454
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 19,
                'tranche' => 3,
                'step' => 8,                
            ],
            [
                'salary' => 55268
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 20,
                'tranche' => 3,
                'step' => 1,                
            ],
            [
                'salary' => 55799
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 20,
                'tranche' => 3,
                'step' => 2,                
            ],
            [
                'salary' => 56633
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 20,
                'tranche' => 3,
                'step' => 3,                
            ],
            [
                'salary' => 57482
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 20,
                'tranche' => 3,
                'step' => 4,                
            ],
            [
                'salary' => 58344
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 20,
                'tranche' => 3,
                'step' => 5,                
            ],
            [
                'salary' => 59221
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 20,
                'tranche' => 3,
                'step' => 6,                
            ],
            [
                'salary' => 60112
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 20,
                'tranche' => 3,
                'step' => 7,                
            ],
            [
                'salary' => 61017
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 20,
                'tranche' => 3,
                'step' => 8,                
            ],
            [
                'salary' => 61937
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 21,
                'tranche' => 3,
                'step' => 1,                
            ],
            [
                'salary' => 62449
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 21,
                'tranche' => 3,
                'step' => 2,                
            ],
            [
                'salary' => 63392
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 21,
                'tranche' => 3,
                'step' => 3,                
            ],
            [
                'salary' => 64351
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 21,
                'tranche' => 3,
                'step' => 4,                
            ],
            [
                'salary' => 65325
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 21,
                'tranche' => 3,
                'step' => 5,                
            ],
            [
                'salary' => 66316
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 21,
                'tranche' => 3,
                'step' => 6,                
            ],
            [
                'salary' => 67322
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 21,
                'tranche' => 3,
                'step' => 7,                
            ],
            [
                'salary' => 68345
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 21,
                'tranche' => 3,
                'step' => 8,                
            ],
            [
                'salary' => 69385
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 22,
                'tranche' => 3,
                'step' => 1,                
            ],
            [
                'salary' => 69963
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 22,
                'tranche' => 3,
                'step' => 2,                
            ],
            [
                'salary' => 71029
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 22,
                'tranche' => 3,
                'step' => 3,                
            ],
            [
                'salary' => 72113
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 22,
                'tranche' => 3,
                'step' => 4,                
            ],
            [
                'salary' => 73214
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 22,
                'tranche' => 3,
                'step' => 5,                
            ],
            [
                'salary' => 74333
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 22,
                'tranche' => 3,
                'step' => 6,                
            ],
            [
                'salary' => 75471
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 22,
                'tranche' => 3,
                'step' => 7,                
            ],
            [
                'salary' => 76627
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 22,
                'tranche' => 3,
                'step' => 8,                
            ],
            [
                'salary' => 77801
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 23,
                'tranche' => 3,
                'step' => 1,                
            ],
            [
                'salary' => 78455
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 23,
                'tranche' => 3,
                'step' => 2,                
            ],
            [
                'salary' => 79659
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 23,
                'tranche' => 3,
                'step' => 3,                
            ],
            [
                'salary' => 80884
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 23,
                'tranche' => 3,
                'step' => 4,                
            ],
            [
                'salary' => 82133
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 23,
                'tranche' => 3,
                'step' => 5,                
            ],
            [
                'salary' => 83474
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 23,
                'tranche' => 3,
                'step' => 6,                
            ],
            [
                'salary' => 84836
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 23,
                'tranche' => 3,
                'step' => 7,                
            ],
            [
                'salary' => 86220
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 23,
                'tranche' => 3,
                'step' => 8,                
            ],
            [
                'salary' => 87628
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 24,
                'tranche' => 3,
                'step' => 1,                
            ],
            [
                'salary' => 88410
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 24,
                'tranche' => 3,
                'step' => 2,                
            ],
            [
                'salary' => 89853
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 24,
                'tranche' => 3,
                'step' => 3,                
            ],
            [
                'salary' => 91320
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 24,
                'tranche' => 3,
                'step' => 4,                
            ],
            [
                'salary' => 92810
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 24,
                'tranche' => 3,
                'step' => 5,                
            ],
            [
                'salary' => 94325
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 24,
                'tranche' => 3,
                'step' => 6,                
            ],
            [
                'salary' => 95865
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 24,
                'tranche' => 3,
                'step' => 7,                
            ],
            [
                'salary' => 97430
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 24,
                'tranche' => 3,
                'step' => 8,                
            ],
            [
                'salary' => 99020
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 25,
                'tranche' => 3,
                'step' => 1,                
            ],
            [
                'salary' => 100788
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 25,
                'tranche' => 3,
                'step' => 2,                
            ],
            [
                'salary' => 102433
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 25,
                'tranche' => 3,
                'step' => 3,                
            ],
            [
                'salary' => 104105
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 25,
                'tranche' => 3,
                'step' => 4,                
            ],
            [
                'salary' => 105804
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 25,
                'tranche' => 3,
                'step' => 5,                
            ],
            [
                'salary' => 107531
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 25,
                'tranche' => 3,
                'step' => 6,                
            ],
            [
                'salary' => 109286
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 25,
                'tranche' => 3,
                'step' => 7,                
            ],
            [
                'salary' => 111070
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 25,
                'tranche' => 3,
                'step' => 8,                
            ],
            [
                'salary' => 112883
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 26,
                'tranche' => 3,
                'step' => 1,                
            ],
            [
                'salary' => 113891
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 26,
                'tranche' => 3,
                'step' => 2,                
            ],
            [
                'salary' => 115749
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 26,
                'tranche' => 3,
                'step' => 3,                
            ],
            [
                'salary' => 117639
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 26,
                'tranche' => 3,
                'step' => 4,                
            ],
            [
                'salary' => 119558
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 26,
                'tranche' => 3,
                'step' => 5,                
            ],
            [
                'salary' => 121510
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 26,
                'tranche' => 3,
                'step' => 6,                
            ],
            [
                'salary' => 123493
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 26,
                'tranche' => 3,
                'step' => 7,                
            ],
            [
                'salary' => 125508
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 26,
                'tranche' => 3,
                'step' => 8,                
            ],
            [
                'salary' => 127557
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 27,
                'tranche' => 3,
                'step' => 1,                
            ],
            [
                'salary' => 128696
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 27,
                'tranche' => 3,
                'step' => 2,                
            ],
            [
                'salary' => 130797
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 27,
                'tranche' => 3,
                'step' => 3,                
            ],
            [
                'salary' => 132931
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 27,
                'tranche' => 3,
                'step' => 4,                
            ],
            [
                'salary' => 135101
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 27,
                'tranche' => 3,
                'step' => 5,                
            ],
            [
                'salary' => 137306
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 27,
                'tranche' => 3,
                'step' => 6,                
            ],
            [
                'salary' => 139547
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 27,
                'tranche' => 3,
                'step' => 7,                
            ],
            [
                'salary' => 141825
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 27,
                'tranche' => 3,
                'step' => 8,                
            ],
            [
                'salary' => 144140
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 28,
                'tranche' => 3,
                'step' => 1,                
            ],
            [
                'salary' => 145427
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 28,
                'tranche' => 3,
                'step' => 2,                
            ],
            [
                'salary' => 147800
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 28,
                'tranche' => 3,
                'step' => 3,                
            ],
            [
                'salary' => 150213
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 28,
                'tranche' => 3,
                'step' => 4,                
            ],
            [
                'salary' => 152664
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 28,
                'tranche' => 3,
                'step' => 5,                
            ],
            [
                'salary' => 155155
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 28,
                'tranche' => 3,
                'step' => 6,                
            ],
            [
                'salary' => 157689
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 28,
                'tranche' => 3,
                'step' => 7,                
            ],
            [
                'salary' => 160262
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 28,
                'tranche' => 3,
                'step' => 8,                
            ],
            [
                'salary' => 162877
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 29,
                'tranche' => 3,
                'step' => 1,                
            ],
            [
                'salary' => 164332
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 29,
                'tranche' => 3,
                'step' => 2,                
            ],
            [
                'salary' => 167015
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 29,
                'tranche' => 3,
                'step' => 3,                
            ],
            [
                'salary' => 169740
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 29,
                'tranche' => 3,
                'step' => 4,                
            ],
            [
                'salary' => 172511
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 29,
                'tranche' => 3,
                'step' => 5,                
            ],
            [
                'salary' => 175326
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 29,
                'tranche' => 3,
                'step' => 6,                
            ],
            [
                'salary' => 178188
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 29,
                'tranche' => 3,
                'step' => 7,                
            ],
            [
                'salary' => 181096
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 29,
                'tranche' => 3,
                'step' => 8,                
            ],
            [
                'salary' => 184052
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 30,
                'tranche' => 3,
                'step' => 1,                
            ],
            [
                'salary' => 185695
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 30,
                'tranche' => 3,
                'step' => 2,                
            ],
            [
                'salary' => 188726
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 30,
                'tranche' => 3,
                'step' => 3,                
            ],
            [
                'salary' => 191806
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 30,
                'tranche' => 3,
                'step' => 4,                
            ],
            [
                'salary' => 194937
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 30,
                'tranche' => 3,
                'step' => 5,                
            ],
            [
                'salary' => 198118
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 30,
                'tranche' => 3,
                'step' => 6,                
            ],
            [
                'salary' => 201352
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 30,
                'tranche' => 3,
                'step' => 7,                
            ],
            [
                'salary' => 204638
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 30,
                'tranche' => 3,
                'step' => 8,                
            ],
            [
                'salary' => 207978
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 31,
                'tranche' => 3,
                'step' => 1,                
            ],
            [
                'salary' => 273278
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 31,
                'tranche' => 3,
                'step' => 2,                
            ],
            [
                'salary' => 278615
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 31,
                'tranche' => 3,
                'step' => 3,                
            ],
            [
                'salary' => 284057
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 31,
                'tranche' => 3,
                'step' => 4,                
            ],
            [
                'salary' => 289605
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 31,
                'tranche' => 3,
                'step' => 5,                
            ],
            [
                'salary' => 295262
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 31,
                'tranche' => 3,
                'step' => 6,                
            ],
            [
                'salary' => 301028
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 31,
                'tranche' => 3,
                'step' => 7,                
            ],
            [
                'salary' => 306908
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 31,
                'tranche' => 3,
                'step' => 8,                
            ],
            [
                'salary' => 312902
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 32,
                'tranche' => 3,
                'step' => 1,                
            ],
            [
                'salary' => 325807
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 32,
                'tranche' => 3,
                'step' => 2,                
            ],
            [
                'salary' => 332378
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 32,
                'tranche' => 3,
                'step' => 3,                
            ],
            [
                'salary' => 339080
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 32,
                'tranche' => 3,
                'step' => 4,                
            ],
            [
                'salary' => 345918
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 32,
                'tranche' => 3,
                'step' => 5,                
            ],
            [
                'salary' => 352894
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 32,
                'tranche' => 3,
                'step' => 6,                
            ],
            [
                'salary' => 360011
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 32,
                'tranche' => 3,
                'step' => 7,                
            ],
            [
                'salary' => 367272
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 32,
                'tranche' => 3,
                'step' => 8,                
            ],
            [
                'salary' => 374678
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 33,
                'tranche' => 3,
                'step' => 1,                
            ],
            [
                'salary' => 411382
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 33,
                'tranche' => 3,
                'step' => 2,                
            ],
            [
                'salary' => 423723
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 1,
                'tranche' => 4,
                'step' => 1,                
            ],
            [
                'salary' => 13000
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 1,
                'tranche' => 4,
                'step' => 2,                
            ],
            [
                'salary' => 13109
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 1,
                'tranche' => 4,
                'step' => 3,                
            ],
            [
                'salary' => 13219
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 1,
                'tranche' => 4,
                'step' => 4,                
            ],
            [
                'salary' => 13329
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 1,
                'tranche' => 4,
                'step' => 5,                
            ],
            [
                'salary' => 13441
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 1,
                'tranche' => 4,
                'step' => 6,                
            ],
            [
                'salary' => 13553
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 1,
                'tranche' => 4,
                'step' => 7,                
            ],
            [
                'salary' => 13666
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 1,
                'tranche' => 4,
                'step' => 8,                
            ],
            [
                'salary' => 13780
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 2,
                'tranche' => 4,
                'step' => 1,                
            ],
            [
                'salary' => 13819
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 2,
                'tranche' => 4,
                'step' => 2,                
            ],
            [
                'salary' => 13925
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 2,
                'tranche' => 4,
                'step' => 3,                
            ],
            [
                'salary' => 14032
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 2,
                'tranche' => 4,
                'step' => 4,                
            ],
            [
                'salary' => 14140
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 2,
                'tranche' => 4,
                'step' => 5,                
            ],
            [
                'salary' => 14248
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 2,
                'tranche' => 4,
                'step' => 6,                
            ],
            [
                'salary' => 14357
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 2,
                'tranche' => 4,
                'step' => 7,                
            ],
            [
                'salary' => 14468
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 2,
                'tranche' => 4,
                'step' => 8,                
            ],
            [
                'salary' => 14578
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 3,
                'tranche' => 4,
                'step' => 1,                
            ],
            [
                'salary' => 14678
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 3,
                'tranche' => 4,
                'step' => 2,                
            ],
            [
                'salary' => 14792
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 3,
                'tranche' => 4,
                'step' => 3,                
            ],
            [
                'salary' => 14905
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 3,
                'tranche' => 4,
                'step' => 4,                
            ],
            [
                'salary' => 15020
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 3,
                'tranche' => 4,
                'step' => 5,                
            ],
            [
                'salary' => 15136
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 3,
                'tranche' => 4,
                'step' => 6,                
            ],
            [
                'salary' => 15251
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 3,
                'tranche' => 4,
                'step' => 7,                
            ],
            [
                'salary' => 15369
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 3,
                'tranche' => 4,
                'step' => 8,                
            ],
            [
                'salary' => 15486
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 4,
                'tranche' => 4,
                'step' => 1,                
            ],
            [
                'salary' => 15586
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 4,
                'tranche' => 4,
                'step' => 2,                
            ],
            [
                'salary' => 15706
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 4,
                'tranche' => 4,
                'step' => 3,                
            ],
            [
                'salary' => 15827
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 4,
                'tranche' => 4,
                'step' => 4,                
            ],
            [
                'salary' => 15948
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 4,
                'tranche' => 4,
                'step' => 5,                
            ],
            [
                'salary' => 16071
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 4,
                'tranche' => 4,
                'step' => 6,                
            ],
            [
                'salary' => 16193
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 4,
                'tranche' => 4,
                'step' => 7,                
            ],
            [
                'salary' => 16318
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 4,
                'tranche' => 4,
                'step' => 8,                
            ],
            [
                'salary' => 16443
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 5,
                'tranche' => 4,
                'step' => 1,                
            ],
            [
                'salary' => 16543
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 5,
                'tranche' => 4,
                'step' => 2,                
            ],
            [
                'salary' => 16671
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 5,
                'tranche' => 4,
                'step' => 3,                
            ],
            [
                'salary' => 16799
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 5,
                'tranche' => 4,
                'step' => 4,                
            ],
            [
                'salary' => 16928
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 5,
                'tranche' => 4,
                'step' => 5,                
            ],
            [
                'salary' => 17057
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 5,
                'tranche' => 4,
                'step' => 6,                
            ],
            [
                'salary' => 17189
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 5,
                'tranche' => 4,
                'step' => 7,                
            ],
            [
                'salary' => 17321
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 5,
                'tranche' => 4,
                'step' => 8,                
            ],
            [
                'salary' => 17453
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 6,
                'tranche' => 4,
                'step' => 1,                
            ],
            [
                'salary' => 17553
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 6,
                'tranche' => 4,
                'step' => 2,                
            ],
            [
                'salary' => 17688
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 6,
                'tranche' => 4,
                'step' => 3,                
            ],
            [
                'salary' => 17824
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 6,
                'tranche' => 4,
                'step' => 4,                
            ],
            [
                'salary' => 17962
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 6,
                'tranche' => 4,
                'step' => 5,                
            ],
            [
                'salary' => 18100
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 6,
                'tranche' => 4,
                'step' => 6,                
            ],
            [
                'salary' => 18238
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 6,
                'tranche' => 4,
                'step' => 7,                
            ],
            [
                'salary' => 18379
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 6,
                'tranche' => 4,
                'step' => 8,                
            ],
            [
                'salary' => 18520
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 7,
                'tranche' => 4,
                'step' => 1,                
            ],
            [
                'salary' => 18620
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 7,
                'tranche' => 4,
                'step' => 2,                
            ],
            [
                'salary' => 18763
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 7,
                'tranche' => 4,
                'step' => 3,                
            ],
            [
                'salary' => 18907
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 7,
                'tranche' => 4,
                'step' => 4,                
            ],
            [
                'salary' => 19053
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 7,
                'tranche' => 4,
                'step' => 5,                
            ],
            [
                'salary' => 19198
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 7,
                'tranche' => 4,
                'step' => 6,                
            ],
            [
                'salary' => 19346
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 7,
                'tranche' => 4,
                'step' => 7,                
            ],
            [
                'salary' => 19494
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 7,
                'tranche' => 4,
                'step' => 8,                
            ],
            [
                'salary' => 19644
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 8,
                'tranche' => 4,
                'step' => 1,                
            ],
            [
                'salary' => 19744
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 8,
                'tranche' => 4,
                'step' => 2,                
            ],
            [
                'salary' => 19923
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 8,
                'tranche' => 4,
                'step' => 3,                
            ],
            [
                'salary' => 20104
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 8,
                'tranche' => 4,
                'step' => 4,                
            ],
            [
                'salary' => 20285
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 8,
                'tranche' => 4,
                'step' => 5,                
            ],
            [
                'salary' => 20468
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 8,
                'tranche' => 4,
                'step' => 6,                
            ],
            [
                'salary' => 20653
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 8,
                'tranche' => 4,
                'step' => 7,                
            ],
            [
                'salary' => 20840
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 8,
                'tranche' => 4,
                'step' => 8,                
            ],
            [
                'salary' => 21029
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 9,
                'tranche' => 4,
                'step' => 1,                
            ],
            [
                'salary' => 21129
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 9,
                'tranche' => 4,
                'step' => 2,                
            ],
            [
                'salary' => 21304
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 9,
                'tranche' => 4,
                'step' => 3,                
            ],
            [
                'salary' => 21483
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 9,
                'tranche' => 4,
                'step' => 4,                
            ],
            [
                'salary' => 21663
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 9,
                'tranche' => 4,
                'step' => 5,                
            ],
            [
                'salary' => 21844
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 9,
                'tranche' => 4,
                'step' => 6,                
            ],
            [
                'salary' => 22026
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 9,
                'tranche' => 4,
                'step' => 7,                
            ],
            [
                'salary' => 22210
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 9,
                'tranche' => 4,
                'step' => 8,                
            ],
            [
                'salary' => 22396
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 10,
                'tranche' => 4,
                'step' => 1,                
            ],
            [
                'salary' => 23176
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 10,
                'tranche' => 4,
                'step' => 2,                
            ],
            [
                'salary' => 23370
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 10,
                'tranche' => 4,
                'step' => 3,                
            ],
            [
                'salary' => 23565
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 10,
                'tranche' => 4,
                'step' => 4,                
            ],
            [
                'salary' => 23762
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 10,
                'tranche' => 4,
                'step' => 5,                
            ],
            [
                'salary' => 23961
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 10,
                'tranche' => 4,
                'step' => 6,                
            ],
            [
                'salary' => 24161
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 10,
                'tranche' => 4,
                'step' => 7,                
            ],
            [
                'salary' => 24363
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 10,
                'tranche' => 4,
                'step' => 8,                
            ],
            [
                'salary' => 24567
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 11,
                'tranche' => 4,
                'step' => 1,                
            ],
            [
                'salary' => 27000
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 11,
                'tranche' => 4,
                'step' => 2,                
            ],
            [
                'salary' => 27284
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 11,
                'tranche' => 4,
                'step' => 3,                
            ],
            [
                'salary' => 27573
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 11,
                'tranche' => 4,
                'step' => 4,                
            ],
            [
                'salary' => 27865
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 11,
                'tranche' => 4,
                'step' => 5,                
            ],
            [
                'salary' => 28161
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 11,
                'tranche' => 4,
                'step' => 6,                
            ],
            [
                'salary' => 28462
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 11,
                'tranche' => 4,
                'step' => 7,                
            ],
            [
                'salary' => 28766
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 11,
                'tranche' => 4,
                'step' => 8,                
            ],
            [
                'salary' => 29075
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 12,
                'tranche' => 4,
                'step' => 1,                
            ],
            [
                'salary' => 29165
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 12,
                'tranche' => 4,
                'step' => 2,                
            ],
            [
                'salary' => 29449
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 12,
                'tranche' => 4,
                'step' => 3,                
            ],
            [
                'salary' => 29737
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 12,
                'tranche' => 4,
                'step' => 4,                
            ],
            [
                'salary' => 30028
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 12,
                'tranche' => 4,
                'step' => 5,                
            ],
            [
                'salary' => 30323
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 12,
                'tranche' => 4,
                'step' => 6,                
            ],
            [
                'salary' => 30622
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 12,
                'tranche' => 4,
                'step' => 7,                
            ],
            [
                'salary' => 30924
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 12,
                'tranche' => 4,
                'step' => 8,                
            ],
            [
                'salary' => 31230
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 13,
                'tranche' => 4,
                'step' => 1,                
            ],
            [
                'salary' => 31320
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 13,
                'tranche' => 4,
                'step' => 2,                
            ],
            [
                'salary' => 31633
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 13,
                'tranche' => 4,
                'step' => 3,                
            ],
            [
                'salary' => 31949
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 13,
                'tranche' => 4,
                'step' => 4,                
            ],
            [
                'salary' => 32269
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 13,
                'tranche' => 4,
                'step' => 5,                
            ],
            [
                'salary' => 32594
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 13,
                'tranche' => 4,
                'step' => 6,                
            ],
            [
                'salary' => 32922
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 13,
                'tranche' => 4,
                'step' => 7,                
            ],
            [
                'salary' => 33254
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 13,
                'tranche' => 4,
                'step' => 8,                
            ],
            [
                'salary' => 33591
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 14,
                'tranche' => 4,
                'step' => 1,                
            ],
            [
                'salary' => 33843
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 14,
                'tranche' => 4,
                'step' => 2,                
            ],
            [
                'salary' => 34187
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 14,
                'tranche' => 4,
                'step' => 3,                
            ],
            [
                'salary' => 34535
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 14,
                'tranche' => 4,
                'step' => 4,                
            ],
            [
                'salary' => 34888
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 14,
                'tranche' => 4,
                'step' => 5,                
            ],
            [
                'salary' => 35244
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 14,
                'tranche' => 4,
                'step' => 6,                
            ],
            [
                'salary' => 35605
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 14,
                'tranche' => 4,
                'step' => 7,                
            ],
            [
                'salary' => 35971
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 14,
                'tranche' => 4,
                'step' => 8,                
            ],
            [
                'salary' => 36341
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 15,
                'tranche' => 4,
                'step' => 1,                
            ],
            [
                'salary' => 36619
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 15,
                'tranche' => 4,
                'step' => 2,                
            ],
            [
                'salary' => 36997
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 15,
                'tranche' => 4,
                'step' => 3,                
            ],
            [
                'salary' => 37380
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 15,
                'tranche' => 4,
                'step' => 4,                
            ],
            [
                'salary' => 37768
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 15,
                'tranche' => 4,
                'step' => 5,                
            ],
            [
                'salary' => 38160
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 15,
                'tranche' => 4,
                'step' => 6,                
            ],
            [
                'salary' => 38557
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 15,
                'tranche' => 4,
                'step' => 7,                
            ],
            [
                'salary' => 38959
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 15,
                'tranche' => 4,
                'step' => 8,                
            ],
            [
                'salary' => 39367
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 16,
                'tranche' => 4,
                'step' => 1,                
            ],
            [
                'salary' => 39672
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 16,
                'tranche' => 4,
                'step' => 2,                
            ],
            [
                'salary' => 40088
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 16,
                'tranche' => 4,
                'step' => 3,                
            ],
            [
                'salary' => 40509
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 16,
                'tranche' => 4,
                'step' => 4,                
            ],
            [
                'salary' => 40935
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 16,
                'tranche' => 4,
                'step' => 5,                
            ],
            [
                'salary' => 41367
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 16,
                'tranche' => 4,
                'step' => 6,                
            ],
            [
                'salary' => 41804
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 16,
                'tranche' => 4,
                'step' => 7,                
            ],
            [
                'salary' => 42247
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 16,
                'tranche' => 4,
                'step' => 8,                
            ],
            [
                'salary' => 42694
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 17,
                'tranche' => 4,
                'step' => 1,                
            ],
            [
                'salary' => 43030
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 17,
                'tranche' => 4,
                'step' => 2,                
            ],
            [
                'salary' => 43488
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 17,
                'tranche' => 4,
                'step' => 3,                
            ],
            [
                'salary' => 43951
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 17,
                'tranche' => 4,
                'step' => 4,                
            ],
            [
                'salary' => 44420
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 17,
                'tranche' => 4,
                'step' => 5,                
            ],
            [
                'salary' => 44895
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 17,
                'tranche' => 4,
                'step' => 6,                
            ],
            [
                'salary' => 45376
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 17,
                'tranche' => 4,
                'step' => 7,                
            ],
            [
                'salary' => 45862
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 17,
                'tranche' => 4,
                'step' => 8,                
            ],
            [
                'salary' => 46355
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 18,
                'tranche' => 4,
                'step' => 1,                
            ],
            [
                'salary' => 46725
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 18,
                'tranche' => 4,
                'step' => 2,                
            ],
            [
                'salary' => 47228
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 18,
                'tranche' => 4,
                'step' => 3,                
            ],
            [
                'salary' => 47738
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 18,
                'tranche' => 4,
                'step' => 4,                
            ],
            [
                'salary' => 48253
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 18,
                'tranche' => 4,
                'step' => 5,                
            ],
            [
                'salary' => 48776
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 18,
                'tranche' => 4,
                'step' => 6,                
            ],
            [
                'salary' => 49305
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 18,
                'tranche' => 4,
                'step' => 7,                
            ],
            [
                'salary' => 49840
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 18,
                'tranche' => 4,
                'step' => 8,                
            ],
            [
                'salary' => 50382
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 19,
                'tranche' => 4,
                'step' => 1,                
            ],
            [
                'salary' => 51357
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 19,
                'tranche' => 4,
                'step' => 2,                
            ],
            [
                'salary' => 52096
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 19,
                'tranche' => 4,
                'step' => 3,                
            ],
            [
                'salary' => 52847
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 19,
                'tranche' => 4,
                'step' => 4,                
            ],
            [
                'salary' => 53610
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 19,
                'tranche' => 4,
                'step' => 5,                
            ],
            [
                'salary' => 54386
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 19,
                'tranche' => 4,
                'step' => 6,                
            ],
            [
                'salary' => 55174
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 19,
                'tranche' => 4,
                'step' => 7,                
            ],
            [
                'salary' => 55976
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 19,
                'tranche' => 4,
                'step' => 8,                
            ],
            [
                'salary' => 56790
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 20,
                'tranche' => 4,
                'step' => 1,                
            ],
            [
                'salary' => 57347
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 20,
                'tranche' => 4,
                'step' => 2,                
            ],
            [
                'salary' => 58181
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 20,
                'tranche' => 4,
                'step' => 3,                
            ],
            [
                'salary' => 59030
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 20,
                'tranche' => 4,
                'step' => 4,                
            ],
            [
                'salary' => 59892
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 20,
                'tranche' => 4,
                'step' => 5,                
            ],
            [
                'salary' => 60769
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 20,
                'tranche' => 4,
                'step' => 6,                
            ],
            [
                'salary' => 61660
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 20,
                'tranche' => 4,
                'step' => 7,                
            ],
            [
                'salary' => 62565
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 20,
                'tranche' => 4,
                'step' => 8,                
            ],
            [
                'salary' => 63485
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 21,
                'tranche' => 4,
                'step' => 1,                
            ],
            [
                'salary' => 63997
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 21,
                'tranche' => 4,
                'step' => 2,                
            ],
            [
                'salary' => 64940
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 21,
                'tranche' => 4,
                'step' => 3,                
            ],
            [
                'salary' => 65899
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 21,
                'tranche' => 4,
                'step' => 4,                
            ],
            [
                'salary' => 66873
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 21,
                'tranche' => 4,
                'step' => 5,                
            ],
            [
                'salary' => 67864
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 21,
                'tranche' => 4,
                'step' => 6,                
            ],
            [
                'salary' => 68870
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 21,
                'tranche' => 4,
                'step' => 7,                
            ],
            [
                'salary' => 69893
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 21,
                'tranche' => 4,
                'step' => 8,                
            ],
            [
                'salary' => 70933
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 22,
                'tranche' => 4,
                'step' => 1,                
            ],
            [
                'salary' => 71511
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 22,
                'tranche' => 4,
                'step' => 2,                
            ],
            [
                'salary' => 72577
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 22,
                'tranche' => 4,
                'step' => 3,                
            ],
            [
                'salary' => 73661
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 22,
                'tranche' => 4,
                'step' => 4,                
            ],
            [
                'salary' => 74762
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 22,
                'tranche' => 4,
                'step' => 5,                
            ],
            [
                'salary' => 75881
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 22,
                'tranche' => 4,
                'step' => 6,                
            ],
            [
                'salary' => 77019
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 22,
                'tranche' => 4,
                'step' => 7,                
            ],
            [
                'salary' => 78175
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 22,
                'tranche' => 4,
                'step' => 8,                
            ],
            [
                'salary' => 79349
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 23,
                'tranche' => 4,
                'step' => 1,                
            ],
            [
                'salary' => 80003
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 23,
                'tranche' => 4,
                'step' => 2,                
            ],
            [
                'salary' => 81207
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 23,
                'tranche' => 4,
                'step' => 3,                
            ],
            [
                'salary' => 82432
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 23,
                'tranche' => 4,
                'step' => 4,                
            ],
            [
                'salary' => 83683
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 23,
                'tranche' => 4,
                'step' => 5,                
            ],
            [
                'salary' => 85049
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 23,
                'tranche' => 4,
                'step' => 6,                
            ],
            [
                'salary' => 86437
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 23,
                'tranche' => 4,
                'step' => 7,                
            ],
            [
                'salary' => 87847
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 23,
                'tranche' => 4,
                'step' => 8,                
            ],
            [
                'salary' => 89281
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 24,
                'tranche' => 4,
                'step' => 1,                
            ],
            [
                'salary' => 90078
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 24,
                'tranche' => 4,
                'step' => 2,                
            ],
            [
                'salary' => 91548
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 24,
                'tranche' => 4,
                'step' => 3,                
            ],
            [
                'salary' => 93043
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 24,
                'tranche' => 4,
                'step' => 4,                
            ],
            [
                'salary' => 94562
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 24,
                'tranche' => 4,
                'step' => 5,                
            ],
            [
                'salary' => 96105
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 24,
                'tranche' => 4,
                'step' => 6,                
            ],
            [
                'salary' => 97674
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 24,
                'tranche' => 4,
                'step' => 7,                
            ],
            [
                'salary' => 99268
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 24,
                'tranche' => 4,
                'step' => 8,                
            ],
            [
                'salary' => 100888
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 25,
                'tranche' => 4,
                'step' => 1,                
            ],
            [
                'salary' => 102690
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 25,
                'tranche' => 4,
                'step' => 2,                
            ],
            [
                'salary' => 104366
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 25,
                'tranche' => 4,
                'step' => 3,                
            ],
            [
                'salary' => 106069
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 25,
                'tranche' => 4,
                'step' => 4,                
            ],
            [
                'salary' => 107800
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 25,
                'tranche' => 4,
                'step' => 5,                
            ],
            [
                'salary' => 109560
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 25,
                'tranche' => 4,
                'step' => 6,                
            ],
            [
                'salary' => 111348
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 25,
                'tranche' => 4,
                'step' => 7,                
            ],
            [
                'salary' => 113166
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 25,
                'tranche' => 4,
                'step' => 8,                
            ],
            [
                'salary' => 115012
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 26,
                'tranche' => 4,
                'step' => 1,                
            ],
            [
                'salary' => 116040
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 26,
                'tranche' => 4,
                'step' => 2,                
            ],
            [
                'salary' => 117933
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 26,
                'tranche' => 4,
                'step' => 3,                
            ],
            [
                'salary' => 119858
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 26,
                'tranche' => 4,
                'step' => 4,                
            ],
            [
                'salary' => 121814
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 26,
                'tranche' => 4,
                'step' => 5,                
            ],
            [
                'salary' => 123803
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 26,
                'tranche' => 4,
                'step' => 6,                
            ],
            [
                'salary' => 125823
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 26,
                'tranche' => 4,
                'step' => 7,                
            ],
            [
                'salary' => 127876
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 26,
                'tranche' => 4,
                'step' => 8,                
            ],
            [
                'salary' => 129964
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 27,
                'tranche' => 4,
                'step' => 1,                
            ],
            [
                'salary' => 131124
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 27,
                'tranche' => 4,
                'step' => 2,                
            ],
            [
                'salary' => 133264
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 27,
                'tranche' => 4,
                'step' => 3,                
            ],
            [
                'salary' => 135440
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 27,
                'tranche' => 4,
                'step' => 4,                
            ],
            [
                'salary' => 137650
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 27,
                'tranche' => 4,
                'step' => 5,                
            ],
            [
                'salary' => 139897
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 27,
                'tranche' => 4,
                'step' => 6,                
            ],
            [
                'salary' => 142180
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 27,
                'tranche' => 4,
                'step' => 7,                
            ],
            [
                'salary' => 144501
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 27,
                'tranche' => 4,
                'step' => 8,                
            ],
            [
                'salary' => 146859
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 28,
                'tranche' => 4,
                'step' => 1,                
            ],
            [
                'salary' => 148171
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 28,
                'tranche' => 4,
                'step' => 2,                
            ],
            [
                'salary' => 150589
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 28,
                'tranche' => 4,
                'step' => 3,                
            ],
            [
                'salary' => 153047
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 28,
                'tranche' => 4,
                'step' => 4,                
            ],
            [
                'salary' => 155545
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 28,
                'tranche' => 4,
                'step' => 5,                
            ],
            [
                'salary' => 158083
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 28,
                'tranche' => 4,
                'step' => 6,                
            ],
            [
                'salary' => 160664
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 28,
                'tranche' => 4,
                'step' => 7,                
            ],
            [
                'salary' => 163286
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 28,
                'tranche' => 4,
                'step' => 8,                
            ],
            [
                'salary' => 165951
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 29,
                'tranche' => 4,
                'step' => 1,                
            ],
            [
                'salary' => 167432
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 29,
                'tranche' => 4,
                'step' => 2,                
            ],
            [
                'salary' => 170166
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 29,
                'tranche' => 4,
                'step' => 3,                
            ],
            [
                'salary' => 172943
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 29,
                'tranche' => 4,
                'step' => 4,                
            ],
            [
                'salary' => 175766
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 29,
                'tranche' => 4,
                'step' => 5,                
            ],
            [
                'salary' => 178634
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 29,
                'tranche' => 4,
                'step' => 6,                
            ],
            [
                'salary' => 181550
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 29,
                'tranche' => 4,
                'step' => 7,                
            ],
            [
                'salary' => 184513
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 29,
                'tranche' => 4,
                'step' => 8,                
            ],
            [
                'salary' => 187525
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 30,
                'tranche' => 4,
                'step' => 1,                
            ],
            [
                'salary' => 189199
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 30,
                'tranche' => 4,
                'step' => 2,                
            ],
            [
                'salary' => 192286
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 30,
                'tranche' => 4,
                'step' => 3,                
            ],
            [
                'salary' => 195425
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 30,
                'tranche' => 4,
                'step' => 4,                
            ],
            [
                'salary' => 198615
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 30,
                'tranche' => 4,
                'step' => 5,                
            ],
            [
                'salary' => 201856
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 30,
                'tranche' => 4,
                'step' => 6,                
            ],
            [
                'salary' => 205151
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 30,
                'tranche' => 4,
                'step' => 7,                
            ],
            [
                'salary' => 208499
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 30,
                'tranche' => 4,
                'step' => 8,                
            ],
            [
                'salary' => 211902
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 31,
                'tranche' => 4,
                'step' => 1,                
            ],
            [
                'salary' => 278434
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 31,
                'tranche' => 4,
                'step' => 2,                
            ],
            [
                'salary' => 283872
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 31,
                'tranche' => 4,
                'step' => 3,                
            ],
            [
                'salary' => 289416
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 31,
                'tranche' => 4,
                'step' => 4,                
            ],
            [
                'salary' => 295069
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 31,
                'tranche' => 4,
                'step' => 5,                
            ],
            [
                'salary' => 300833
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 31,
                'tranche' => 4,
                'step' => 6,                
            ],
            [
                'salary' => 306708
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 31,
                'tranche' => 4,
                'step' => 7,                
            ],
            [
                'salary' => 312699
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 31,
                'tranche' => 4,
                'step' => 8,                
            ],
            [
                'salary' => 318806
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 32,
                'tranche' => 4,
                'step' => 1,                
            ],
            [
                'salary' => 331954
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 32,
                'tranche' => 4,
                'step' => 2,                
            ],
            [
                'salary' => 338649
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 32,
                'tranche' => 4,
                'step' => 3,                
            ],
            [
                'salary' => 345478
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 32,
                'tranche' => 4,
                'step' => 4,                
            ],
            [
                'salary' => 352445
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 32,
                'tranche' => 4,
                'step' => 5,                
            ],
            [
                'salary' => 359553
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 32,
                'tranche' => 4,
                'step' => 6,                
            ],
            [
                'salary' => 366804
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 32,
                'tranche' => 4,
                'step' => 7,                
            ],
            [
                'salary' => 374202
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 32,
                'tranche' => 4,
                'step' => 8,                
            ],
            [
                'salary' => 381748
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 33,
                'tranche' => 4,
                'step' => 1,                
            ],
            [
                'salary' => 419144
            ]
        );
 $salary_grade = SalaryGrade::updateOrCreate(
            [
                'salary_grade' => 33,
                'tranche' => 4,
                'step' => 2,                
            ],
            [
                'salary' => 431718
            ]
        );
        Schema::enableForeignKeyConstraints();
    }
}
