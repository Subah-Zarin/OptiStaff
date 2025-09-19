<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class CheckAndMigrate extends Command
{
    protected $signature = 'db:check-migrate';
    protected $description = 'Check pending migrations and migrate/seed if needed';

    public function handle()
    {
        $this->info('Checking database migrations...');

        try {
            DB::table('migrations')->count();
            $this->info('Migrations table exists. Running pending migrations...');
            Artisan::call('migrate', ['--force' => true]);
            $this->info('Migrations completed.');
        } catch (\Exception $e) {
            $this->warn('Fresh database detected. Running migrations and seeding...');
            Artisan::call('migrate', ['--force' => true]);
            Artisan::call('db:seed', ['--force' => true]);
            $this->info('Migrations and seeding completed.');
        }

        return 0;
    }
}
