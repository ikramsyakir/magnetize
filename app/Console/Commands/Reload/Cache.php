<?php

namespace App\Console\Commands\Reload;

use Illuminate\Console\Command;

class Cache extends Command
{
    protected $signature = 'reload:cache';

    protected $description = 'Reload all cache';

    public function handle(): int
    {
        $this->call('event:clear');
        $this->call('optimize:clear');
        $this->call('route:clear');
        $this->call('view:clear');
        $this->call('config:clear');
        $this->call('cache:clear');

        $this->info('Successfully reload caches.');

        return Command::SUCCESS;
    }
}
