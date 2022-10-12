<?php

namespace MtLib\ModuleHelper\Providers;

use Illuminate\Support\ServiceProvider;
use MtLib\ModuleHelper\Console\CreateModelAttachmentTemplate;
use MtLib\ModuleHelper\Console\CreateModelTemplate;
use MtLib\ModuleHelper\Console\CreateModuleTemplate;

class ModuleHelperServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->commands([
                            CreateModelTemplate::class,
                            CreateModelAttachmentTemplate::class,
                            CreateModuleTemplate::class,
                        ]);
    }
}
