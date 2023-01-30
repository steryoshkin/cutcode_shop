<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'shop:install';

    protected $description = 'Installation';

    public function handle(): int
    {
//        - composer install
//    - php artisan storage:link
//    - php artisan migrate

        $this->call('storage:link');
        $this->call('migrate');

        return self::SUCCESS;
    }
}
