<?php

namespace App\Providers;

use App\Models\Children;
use App\Models\Employee;
use App\Models\Education;
use App\Models\Reference;
use App\Models\Eligibility;
use Illuminate\Support\Str;
use App\Models\Volunteering;
use App\Models\WorkExperience;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Javoscript\MacroableModels\Facades\MacroableModels;

class PdsMacrosServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // init variables
        $toPdsFuction = function () {
            return collect($this)->mapWithKeys(function ($value, $key) {
                if(in_array($key,['memberships','skills','recognitions'])) {
                    if($value === null)
                        $value = [];
                }

                // if(in_array($key, ['is_affiliated_third','is_affiliated_fourth','is_found_guilty','is_criminally_charged','is_convicted','is_separated_service','is_candidate','is_resigned','is_immigrant','is_indigenous','is_disabled','is_solo'])) {
                //     if ($value === null)
                //         $value = false;
                // }

                if($value === null)
                    return [$key => "N/A"];

                $type = gettype($value);

                $data = match($type) {
                    'string' => [$key => Str::upper($value)],
                    'array' => [$key => (object) array_map(function($item) {return Str::upper($item);}, $value)],
                    default => [$key => $value]
                };

                return $data;
            });
        };

        // Collection Macro
        Collection::macro('toPDS', $toPdsFuction);

        // Employee Macro
        MacroableModels::addMacro(Employee::class, 'toPDS', $toPdsFuction);

        // children Macro
        MacroableModels::addMacro(Children::class, 'toPDS', $toPdsFuction);

        // education Macro
        MacroableModels::addMacro(Education::class, 'toPDS', $toPdsFuction);

        // eligibility Macro
        MacroableModels::addMacro(Eligibility::class, 'toPDS', $toPdsFuction);

        // WorkExpericence Macro
        MacroableModels::addMacro(WorkExperience::class, 'toPDS', $toPdsFuction);

        // Volunteering Macro
        MacroableModels::addMacro(Volunteering::class, 'toPDS', $toPdsFuction);

        // Volunteering Macro
        MacroableModels::addMacro(Reference::class, 'toPDS', $toPdsFuction);
    }
}
