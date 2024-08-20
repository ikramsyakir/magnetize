<?php

namespace App\Console\Commands\Reload;

use Illuminate\Console\Command;

class All extends Command
{
    protected $signature = 'reload:all';

    protected $description = 'Reload all cache, database and upload file';

    public function handle(): int
    {
        $this->call('reload:cache');
        $this->call('reload:db', ['--dev' => true]);

        $this->info('Successfully reload caches, database and upload file');

        return Command::SUCCESS;
    }
}
