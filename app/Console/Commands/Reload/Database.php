<?php

namespace App\Console\Commands\Reload;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class Database extends Command
{
    protected $signature = 'reload:db {--dev}';

    protected $description = 'Reload database and clear all uploaded file';

    public function handle(): int
    {
        if (app()->environment() == 'production') {
            $this->comment('Cannot run on production environment.');

            return Command::FAILURE;
        }

        $this->call('migrate:fresh', ['--quiet' => true]);
        File::cleanDirectory(storage_path('uploads'));

        if ($this->option('dev')) {
            $this->call('db:seed');
        }

        $this->info('Successfully reload database.');

        return Command::SUCCESS;
    }
}
