<?php

namespace App\Providers;

use App\Models\Position;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;
use Javoscript\MacroableModels\Facades\MacroableModels;

class PdfMacrosServiceProvider extends ServiceProvider
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
        // Position Macro
        MacroableModels::addMacro(Position::class, 'toPDF', function () {
            return collect($this)->mapWithKeys(function ($value, $key) {
                $type = gettype($value);

                $data = match($type) {
                    'string' => [$key => Str::upper($value)],
                    default => [$key => $value]
                };

                return $data;
            });
        });
    }
}
