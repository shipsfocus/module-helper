<?php

namespace MtLib\ModuleHelper\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use MtLib\ModuleHelper\Traits\CreateTemplateTrait;

class CreateModelTemplate extends Command
{
    use CreateTemplateTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mtech:make-model {module} {table} {model} {--meta}';

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
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        if ($this->option('meta')) {
            $this->createFile('migration', true);
            $this->createFile('model', true);
            $this->createFile('contract', true);
            $this->createFile('repository', true);
            $this->createFile('controller', true);
            $this->createFile('resource', true);
            $this->createFile('service', true);
        } else {
            $this->createFile('migration');
            $this->createFile('model');
            $this->createFile('contract');
            $this->createFile('repository');
            $this->createFile('controller');
            $this->createFile('resource');
            $this->createFile('store_request');
            $this->createFile('update_request');
            $this->createFile('service');
        }

        $this->comment('Important Note:');
        $this->comment('Please bind Contract and Repository in Modules/' . $this->argument('module') . '/Config/config.php');

        return true;
    }
}
