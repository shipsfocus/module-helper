<?php

namespace MtLib\ModuleHelper\Traits;

use Illuminate\Support\Pluralizer;
use Nwidart\Modules\Facades\Module;

trait CreateTemplateTrait
{
    protected $is_attachment;
    protected $is_meta;

    public function createFile($type, $is_meta = false, $is_attachment = false)
    {
        $this->is_meta = $is_meta;
        $this->is_attachment = $is_attachment;

        $path = $this->getSourceFilePath($type);

        $this->makeDirectory(dirname($path));

        $contents = $this->getSourceFile($type);

        if (!$this->files->exists($path)) {
            $this->files->put($path, $contents);
            $this->info("File : {$path} created");
        } else {
            $this->info("File : {$path} already exits");
        }
    }

    public function getStubPath($type)
    {
        switch ($type) {
            case 'model':
                if ($this->is_meta) {
                    return __DIR__ . '/../stubs/Meta/MetaModel.stub';
                }
                return $this->is_attachment ? __DIR__ . '/../stubs/Attachment/AttachmentModel.stub' : __DIR__ . '/../stubs/Standard/Model.stub';
            case 'contract':
                return $this->is_attachment ? __DIR__ . '/../stubs/Attachment/AttachmentContract.stub' : __DIR__ . '/../stubs/Standard/Contract.stub';
            case 'repository':
                return $this->is_attachment ? __DIR__ . '/../stubs/Attachment/AttachmentRepository.stub' : __DIR__ . '/../stubs/Standard/Repository.stub';
            case 'controller':
                if ($this->is_meta) {
                    return __DIR__ . '/../stubs/Meta/MetaController.stub';
                }
                return $this->is_attachment ? __DIR__ . '/../stubs/Attachment/AttachmentController.stub' : __DIR__ . '/../stubs/Standard/Controller.stub';
            case 'resource':
                return $this->is_attachment ? __DIR__ . '/../stubs/Attachment/AttachmentResource.stub' : __DIR__ . '/../stubs/Standard/Resource.stub';
            case 'attachment_request':
                return __DIR__ . '/../stubs/Attachment/AttachmentRequest.stub';
            case 'store_request':
                return __DIR__ . '/../stubs/Standard/StoreRequest.stub';
            case 'update_request':
                return __DIR__ . '/../stubs/Standard/UpdateRequest.stub';
            case 'service':
                return __DIR__ . '/../stubs/Standard/Service.stub';
            default:
                if ($this->is_meta) {
                    return __DIR__ . '/../stubs/Meta/MetaMigration.stub';
                }
                return $this->is_attachment ? __DIR__ . '/../stubs/Attachment/AttachmentMigration.stub' : __DIR__ . '/../stubs/Standard/Migration.stub';
        }
    }

    public function getStubVariables()
    {
        return [
            'MODULE'           => $this->argument('module'),
            'MODULE_CONFIG'    => Module::find($this->argument('module'))->getLowerName(),
            'MODEL'            => $this->getSingularClassName($this->argument('model')),
            'MODEL_LOWERCASE'  => lcfirst($this->getSingularClassName($this->argument('model'))),
            'MIGRATION_CLASS'  => $this->is_attachment ? 'Create' . $this->getSingularClassName($this->argument('model')) . 'AttachmentsTable' : 'Create' . $this->getPluralClassName($this->argument('model')) . 'Table',
            'TABLE'            => $this->argument('table'),
            'FOREIGN_KEY'      => strtolower($this->argument('model')) . '_id',
            'MODEL_CLASS'      => $this->is_attachment ? $this->getSingularClassName($this->argument('model')) . 'Attachment' : $this->getSingularClassName($this->argument('model')),
            'CONTRACT_CLASS'   => $this->is_attachment ? $this->getSingularClassName($this->argument('model')) . 'AttachmentContract' : $this->getSingularClassName($this->argument('model')) . 'Contract',
            'REPOSITORY_CLASS' => $this->is_attachment ? $this->getSingularClassName($this->argument('model')) . 'AttachmentRepository' : $this->getSingularClassName($this->argument('model')) . 'Repository',
            'CONTROLLER_CLASS' => $this->is_attachment ? $this->getSingularClassName($this->argument('model')) . 'AttachmentController' : $this->getSingularClassName($this->argument('model')) . 'Controller',
            'RESOURCE_CLASS'   => $this->is_attachment ? $this->getSingularClassName($this->argument('model')) . 'AttachmentResource' : $this->getSingularClassName($this->argument('model')) . 'Resource',
            'SERVICE_CLASS'    => $this->getSingularClassName($this->argument('model')) . 'Service',
        ];
    }

    public function getSourceFile($type)
    {
        return $this->getStubContents($this->getStubPath($type), $this->getStubVariables());
    }

    public function getStubContents($stub, $stubVariables = [])
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('$' . $search . '$', $replace, $contents);
        }

        return $contents;

    }

    public function getSourceFilePath($type)
    {
        $path = base_path('Modules') . DIRECTORY_SEPARATOR . $this->getSingularClassName($this->argument('module')) . DIRECTORY_SEPARATOR;
        $model_singular_name = $this->getSingularClassName($this->argument('model'));
        $migration_prefix = now()->format('Y_m_d_His');

        switch ($type) {
            case 'model':
                return $this->is_attachment
                    ? $path . 'Models' . DIRECTORY_SEPARATOR . $model_singular_name . 'Attachment.php'
                    : $path . 'Models' . DIRECTORY_SEPARATOR . $model_singular_name . '.php';
            case 'contract':
                return $this->is_attachment
                    ? $path . 'Contracts' . DIRECTORY_SEPARATOR . $model_singular_name . 'AttachmentContract.php'
                    : $path . 'Contracts' . DIRECTORY_SEPARATOR . $model_singular_name . 'Contract.php';
            case 'repository':
                return $this->is_attachment
                    ? $path . 'Repositories' . DIRECTORY_SEPARATOR . $model_singular_name . 'AttachmentRepository.php'
                    : $path . 'Repositories' . DIRECTORY_SEPARATOR . $model_singular_name . 'Repository.php';
            case 'controller':
                return $this->is_attachment
                    ? $path . 'Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . $model_singular_name . 'AttachmentController.php'
                    : $path . 'Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . $model_singular_name . 'Controller.php';
            case 'resource':
                return $this->is_attachment
                    ? $path . 'Http' . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . $model_singular_name . 'AttachmentResource.php'
                    : $path . 'Http' . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . $model_singular_name . 'Resource.php';
            case 'attachment_request':
                return $path . 'Http' . DIRECTORY_SEPARATOR . 'Requests' . DIRECTORY_SEPARATOR . 'Attachment' . DIRECTORY_SEPARATOR . 'Store.php';
            case 'store_request':
                return $path . 'Http' . DIRECTORY_SEPARATOR . 'Requests' . DIRECTORY_SEPARATOR . $model_singular_name . DIRECTORY_SEPARATOR . 'Store.php';
            case 'update_request':
                return $path . 'Http' . DIRECTORY_SEPARATOR . 'Requests' . DIRECTORY_SEPARATOR . $model_singular_name . DIRECTORY_SEPARATOR . 'Update.php';
            case 'service':
                return $path . 'Services' . DIRECTORY_SEPARATOR . $model_singular_name . 'Service.php';
            default:
                return $this->is_attachment
                    ? $path . 'Database' . DIRECTORY_SEPARATOR . 'Migrations' . DIRECTORY_SEPARATOR . $migration_prefix . '_create_' . $this->argument('table') . '_attachments_table.php'
                    : $path . 'Database' . DIRECTORY_SEPARATOR . 'Migrations' . DIRECTORY_SEPARATOR . $migration_prefix . '_create_' . $this->argument('table') . '_table.php';
        }
    }

    public function getSingularClassName($name)
    {
        return ucwords(Pluralizer::singular($name));
    }

    public function getPluralClassName($name)
    {
        return ucwords(Pluralizer::plural($name));
    }

    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }
}
