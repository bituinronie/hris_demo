<?php

namespace Database\Seeders;

use App\Models\RequestType;
use Illuminate\Database\Seeder;

class RequestTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RequestType::updateOrCreate([
            'id' => 1
        ], [
            'code' => 'VL',
            'description' => 'Vacation Leave',
            'filing_period_type' => 'BEFORE',
            'filing_period_days' => 3,
            'request_limit_min' => null,
            'request_limit_max' => null,
            'category' => 'LEAVES',
            'based_on' => 'SCHEDULE',
        ]);

        RequestType::updateOrCreate([
            'id' => 2
        ], [
            'code' => 'SL',
            'description' => 'Sick Leave',
            'filing_period_type' => 'EITHER',
            'filing_period_days' => 3,
            'request_limit_min' => null,
            'request_limit_max' => null,
            'category' => 'LEAVES',
            'based_on' => 'SCHEDULE',
        ]);
        RequestType::updateOrCreate([
            'id' => 3
        ], [
            'code' => 'ML',
            'description' => 'Mandatory Leave',
            'filing_period_type' => 'BEFORE',
            'filing_period_days' => 3,
            'request_limit_min' => 1,
            'request_limit_max' => 5,
            'category' => 'LEAVES',
            'based_on' => 'SCHEDULE',
        ]);
        RequestType::updateOrCreate([
            'id' => 4
        ], [
            'code' => 'MLD',
            'description' => 'Mandatory Leave Disapproval',
            'filing_period_type' => 'BEFORE',
            'filing_period_days' => 3,
            'request_limit_min' => null,
            'request_limit_max' => null,
            'category' => 'LEAVES',
            'based_on' => 'SCHEDULE',
        ]);
        RequestType::updateOrCreate([
            'id' => 5
        ], [
            'code' => 'SPL',
            'description' => 'Special Priviledge Leave',
            'filing_period_type' => 'EITHER',
            'filing_period_days' => 7,
            'request_limit_min' => 1,
            'request_limit_max' => 3,
            'category' => 'LEAVES',
            'based_on' => 'SCHEDULE',
        ]);
        RequestType::updateOrCreate([
            'id' => 6
        ], [
            'code' => 'SOPL',
            'description' => 'Solo Parent Leave',
            'filing_period_type' => 'EITHER',
            'filing_period_days' => 0,
            'request_limit_min' => 1,
            'request_limit_max' => 7,
            'category' => 'LEAVES',
            'based_on' => 'SCHEDULE',
        ]);
        RequestType::updateOrCreate([
            'id' => 7
        ], [
            'code' => 'SEL',
            'description' => 'Special Emergency Leave',
            'filing_period_type' => 'EITHER',
            'filing_period_days' => 0,
            'request_limit_min' => 5,
            'request_limit_max' => 10,
            'category' => 'LEAVES',
            'based_on' => 'SCHEDULE',
        ]);
        RequestType::updateOrCreate([
            'id' => 8
        ], [
            'code' => 'PL',
            'description' => 'Paternity Leave',
            'filing_period_type' => 'BEFORE',
            'filing_period_days' => 0,
            'request_limit_min' => 1,
            'request_limit_max' => 7,
            'category' => 'LEAVES',
            'based_on' => 'SCHEDULE',
        ]);
        RequestType::updateOrCreate([
            'id' => 9
        ], [
            'code' => 'EML',
            'description' => 'Extended Marital Leave',
            'filing_period_type' => 'BEFORE',
            'filing_period_days' => 45,
            'request_limit_min' => 1,
            'request_limit_max' => 105,
            'category' => 'LEAVES',
            'based_on' => 'CALENDAR',
        ]);
        RequestType::updateOrCreate([
            'id' => 10
        ], [
            'code' => 'RL',
            'description' => 'Rehabilitation Leave',
            'filing_period_type' => 'AFTER',
            'filing_period_days' => 7,
            'request_limit_min' => 1,
            'request_limit_max' => 60,
            'category' => 'LEAVES',
            'based_on' => 'CALENDAR',
        ]);
        RequestType::updateOrCreate([
            'id' => 11
        ], [
            'code' => 'MCW',
            'description' => 'Magna Carta of Women',
            'filing_period_type' => 'ANYTIME',
            'filing_period_days' => null,
            'request_limit_min' => 10,
            'request_limit_max' => 60,
            'category' => 'LEAVES',
            'based_on' => 'CALENDAR',
        ]);
        RequestType::updateOrCreate([
            'id' => 12
        ], [
            'code' => 'STL',
            'description' => 'Study Leave',
            'filing_period_type' => 'BEFORE',
            'filing_period_days' => 0,
            'request_limit_min' => 1,
            'request_limit_max' => 180,
            'category' => 'LEAVES',
            'based_on' => 'CALENDAR',
        ]);
        RequestType::updateOrCreate([
            'id' => 13
        ], [
            'code' => 'VAWC',
            'description' => 'Violence Against Women & Children',
            'filing_period_type' => 'ANYTIME',
            'filing_period_days' => null,
            'request_limit_min' => 1,
            'request_limit_max' => 10,
            'category' => 'LEAVES',
            'based_on' => 'CALENDAR',
        ]);
        RequestType::updateOrCreate([
            'id' => 14
        ], [
            'code' => 'RM',
            'description' => 'Regular Monetization (Vacation Leave)',
            'filing_period_type' => 'MONTH',
            'filing_period_month' => ['MAY', 'NOVEMBER'],
            'filing_period_days' => null,
            'request_limit_min' => 15,
            'request_limit_max' => 80,
            'category' => 'LEAVES',
            'based_on' => 1,
        ]);
        RequestType::updateOrCreate([
            'id' => 15
        ], [
            'code' => 'OB',
            'description' => 'Official Business',
            'filing_period_type' => 'EITHER',
            'filing_period_days' => 7,
            'request_limit_min' => null,
            'request_limit_max' => null,
            'category' => 'OB',
            'based_on' => 'SCHEDULE',
        ]);
        RequestType::updateOrCreate([
            'id' => 16
        ], [
            'code' => 'OT',
            'description' => 'Overtime',
            'filing_period_type' => 'ANYTIME',
            'filing_period_days' => null,
            'request_limit_min' => null,
            'request_limit_max' => null,
            'category' => 'OVERTIME',
            'based_on' => 'OVERTIME',
        ]);
        RequestType::updateOrCreate([
            'id' => 17
        ], [
            'code' => 'SPM',
            'description' => 'Special Monetization (Sick Leave)',
            'filing_period_type' => 'MONTH',
            'filing_period_month' => ['MAY', 'NOVEMBER'],
            'filing_period_days' => null,
            'request_limit_min' => 30,
            'request_limit_max' => 80,
            'category' => 'LEAVES',
            'based_on' => 2,
        ]);
        RequestType::updateOrCreate([
            'id' => 18
        ], [
            'code' => 'CTO',
            'description' => 'Compensatory Time-off',
            'filing_period_type' => 'ANYTIME',
            'filing_period_days' => null,
            'request_limit_min' => null,
            'request_limit_max' => null,
            'category' => 'LEAVES',
            'based_on' => 'SCHEDULE',
        ]);
        RequestType::updateOrCreate([
            'id' => 19
        ], [
            'code' => 'COC',
            'description' => 'Compensatory Overtime Credit',
            'filing_period_type' => 'ANYTIME',
            'filing_period_days' => null,
            'request_limit_min' => null,
            'request_limit_max' => null,
            'category' => 'OVERTIME',
            'based_on' => 'OVERTIME',
        ]);
        RequestType::updateOrCreate([
            'id' => 20
        ], [
            'code' => 'PR',
            'description' => 'Personel Reports (Certificate of Employment)',
            'filing_period_type' => 'ANYTIME',
            'filing_period_days' => null,
            'request_limit_min' => null,
            'request_limit_max' => null,
            'category' => 'REQUEST',
            'based_on' => null,
        ]);
        RequestType::updateOrCreate([
            'id' => 21
        ], [
            'code' => 'MTL',
            'description' => 'Maternity Leave',
            'filing_period_type' => 'BEFORE',
            'filing_period_days' => 45,
            'request_limit_min' => 1,
            'request_limit_max' => 105,
            'category' => 'LEAVES',
            'based_on' => 'CALENDAR',
        ]);
        RequestType::updateOrCreate([
            'id' => 22
        ], [
            'code' => 'TL',
            'description' => 'Terminal Leave',
            'filing_period_type' => 'ANYTIME',
            'filing_period_days' => null,
            'request_limit_min' => null,
            'request_limit_max' => null,
            'category' => 'LEAVES',
            'based_on' => 'SCHEDULE',
        ]);
        RequestType::updateOrCreate([
            'id' => 23
        ], [
            'code' => 'AL',
            'description' => 'Adoption Leave',
            'filing_period_type' => 'ANYTIME',
            'filing_period_days' => null,
            'request_limit_min' => null,
            'request_limit_max' => null,
            'category' => 'LEAVES',
            'based_on' => 'CALENDAR',
        ]);
        RequestType::updateOrCreate([
            'id' => 24
        ], [
            'code' => 'SR',
            'description' => 'Service Record',
            'filing_period_type' => 'ANYTIME',
            'filing_period_days' => null,
            'request_limit_min' => null,
            'request_limit_max' => null,
            'category' => 'REQUEST',
            'based_on' => null,
        ]);
        RequestType::updateOrCreate([
            'id' => 25
        ], [
            'code' => 'CE',
            'description' => 'Certificate of Employment',
            'filing_period_type' => 'ANYTIME',
            'filing_period_days' => null,
            'request_limit_min' => null,
            'request_limit_max' => null,
            'category' => 'REQUEST',
            'based_on' => null,
        ]);
        RequestType::updateOrCreate([
            'id' => 26
        ], [
            'code' => 'CLC',
            'description' => 'Certificate of Leave Credits',
            'filing_period_type' => 'ANYTIME',
            'filing_period_days' => null,
            'request_limit_min' => null,
            'request_limit_max' => null,
            'category' => 'REQUEST',
            'based_on' => null,
        ]);
        RequestType::updateOrCreate([
            'id' => 27
        ], [
            'code' => 'CS',
            'description' => 'Change Status',
            'filing_period_type' => 'ANYTIME',
            'filing_period_days' => null,
            'request_limit_min' => null,
            'request_limit_max' => null,
            'category' => 'REQUEST',
            'based_on' => null,
        ]);
        RequestType::updateOrCreate([
            'id' => 28
        ], [
            'code' => 'CEWC',
            'description' => 'Certificate of Employment with Compensation (c/o Finance)',
            'filing_period_type' => 'ANYTIME',
            'filing_period_days' => null,
            'request_limit_min' => null,
            'request_limit_max' => null,
            'category' => 'REQUEST',
            'based_on' => null,
        ]);
        RequestType::updateOrCreate([
            'id' => 29
        ], [
            'code' => 'OTHERS',
            'description' => 'Others',
            'filing_period_type' => 'ANYTIME',
            'filing_period_days' => null,
            'request_limit_min' => null,
            'request_limit_max' => null,
            'category' => 'REQUEST',
            'based_on' => null,
        ]);
    }
}
