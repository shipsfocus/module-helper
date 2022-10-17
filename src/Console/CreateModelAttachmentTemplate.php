<?php

namespace MtLib\ModuleHelper\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use MtLib\ModuleHelper\Traits\CreateTemplateTrait;

class CreateModelAttachmentTemplate extends Command
{
    use CreateTemplateTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mtech:make-attachment {module} {table} {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Migration, Model, Contract, Repository for new Model Attachment';

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
        $this->createFile('migration', false, true);
        $this->createFile('model', false, true);
        $this->createFile('contract', false, true);
        $this->createFile('repository', false, true);
        $this->createFile('controller', false, true);
        $this->createFile('resource', false, true);
        $this->createFile('attachment_request', false, true);

        $this->comment('Important Note:');
        $this->comment('- Please bind Contract and Repository in Modules/' . $this->argument('module') . '/Config/config.php');
        $this->comment('- Please setup attachment storage path in "attachments" array in Modules/' . $this->argument('module') . '/Config/config.php');
        $this->comment('- Please add attachment relationship to Modules/'  . $this->argument('module') . '/Models/'. $this->argument('model') . '.php');

        return true;
    }
}
