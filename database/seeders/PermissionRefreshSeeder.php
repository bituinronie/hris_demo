<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class PermissionRefreshSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees = User::all()
                        //->filter(fn($item) => $item->hasRole('Employee')) // NOTE: remove this if you want to sync permission by role
                        ->map(fn($item) => $item->syncPermissionByRole());
    }
}
