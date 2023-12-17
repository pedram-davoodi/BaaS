<?php

namespace App\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Passport::ignoreRoutes();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * Custom macro to perform joining between two collections based on specified keys.
         *
         * @param  Collection  $collection The collection to join with.
         * @param  string  $firstKey The key in the main collection to compare.
         * @param  string  $secondKey The key in the secondary collection to compare.
         * @param  string  $attrName The attribute name to add from the secondary collection.
         * @return Collection The combined collection after joining.
         */
        Collection::macro('joinCollections', function ($collection, $firstKey, $secondKey, $attrName) {
            $combinedCollection = new Collection();

            foreach ($this as $item1) {
                foreach ($collection as $item2) {
                    if ($item1[$firstKey] === $item2[$secondKey]) {
                        $combinedCollection->add(collect($item1)->merge([$attrName => collect($item2)]));
                    }
                }
            }

            return $combinedCollection;
        });

        Collection::macro('leftJoinCollections', function ($collection, $firstKey, $secondKey, $attrName) {
            $combinedCollection = new Collection();

            foreach ($this as $item1) {
                $matched = false;
                foreach ($collection as $item2) {
                    if ($item1[$firstKey] === $item2[$secondKey]) {
                        $combinedCollection->add(collect($item1)->merge([$attrName => collect($item2)]));
                        $matched = true;
                    }
                }
                if (!$matched) {
                    $combinedCollection->add(collect($item1)->merge([$attrName => null])); // Add unmatched item from the left collection
                }
            }

            return $combinedCollection;
        });


    }
}
