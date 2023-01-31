<?php

namespace App\Providers;

use App\Http\Kernel;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Connection;
use Illuminate\Database\Events\QueryExecuted;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Model::shouldBeStrict(!app()->isProduction());

        if(app()->isProduction()) {
            DB::whenQueryingForLongerThan(CarbonInterval::seconds(5), function (Connection $connection, QueryExecuted $event) {
                logger()
                    ->channel('telegram')
                    ->debug('whenQueryingForLongerThan: ' . $connection->totalQueryDuration());
            });

            DB::listen(function ($query) {

                if($query->time > 100) {
                    logger()
                        ->channel('telegram')
                        ->debug('whenQueryingForLongerThan: ' . $query->sql, $query->binding);

                }
            });

            $kernel = app(Kernel::class);


            $kernel->whenRequestLifecycleIsLongerThan(
                CarbonInterval::seconds(4),
                function () {
                    logger()
                        ->channel('telegram')
                        ->debug('whenQueryingForLongerThan: ' . request()->url());
                }
            );
        }
    }
}
