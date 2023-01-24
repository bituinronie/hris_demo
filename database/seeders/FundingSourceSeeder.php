<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FundingSource;

class FundingSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $funding_source = FundingSource::updateOrCreate([
            'code' => 'FUND 101'
       ],
       [
            'description' => ''
       ]);
       $funding_source = FundingSource::updateOrCreate([
            'code' => 'FUND 152'
       ],
       [
            'description' => ''
       ]);
    }
}
