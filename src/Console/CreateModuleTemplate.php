<?php

namespace MtLib\ModuleHelper\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

class CreateModuleTemplate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mtech:make-module {module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Migration, Model, Contract, Repository for new Model';

    protected $files;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Config::set('modules.stubs.path', base_path() . '/vendor/mtech/module-helper/src/stubs/Module');
        Artisan::call('config:cache');
        Artisan::call('route:cache');
        Artisan::call('module:make ' . $this->argument('module'));
        return true;
    }
}
