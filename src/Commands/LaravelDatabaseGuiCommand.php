<?php

namespace DanielHOfficial\LaravelDatabaseGui\Commands;

use Illuminate\Console\Command;

class LaravelDatabaseGuiCommand extends Command
{
    public $signature = 'laravel-database-gui';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
