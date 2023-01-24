<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class CollectionServiceProvider extends ServiceProvider
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

        Collection::macro('toUpper',  function () {
            return collect($this)->mapWithKeys(function ($value, $key) {
                $type = gettype($value);

                $data = match($type) {
                    'string' => [$key => Str::upper($value)],
                    'array' => [$key => (object) array_map(function($item) {return Str::upper($item);}, $value)],
                    default => [$key => $value]
                };

                return $data;
            });
        });

        Collection::macro('getFromColumn', fn($key) => collect($this)->map(function($item) use ($key) { return $item[$key]; }));

        Collection::macro('isOnArray', function($item) {
            $isExist = false;

            foreach ($this as $value) {
                if($value == $item) {
                    $isExist = true;

                    break;
                }
            }

            return $isExist;
        });

    }
}
