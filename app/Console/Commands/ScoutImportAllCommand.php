<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ScoutImportAllCommand extends Command
{
    protected $name = 'scout:import:all';

    public function handle()
    {
        $this->call('scout:import', ['model' => 'App\\Models\\Child']);
        $this->call('scout:import', ['model' => 'App\\Models\\Chat']);
    }
}
