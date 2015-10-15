<?php
namespace Concrete\Package\CommunityCkeditor\Src\Editor;

use \Concrete\Core\Foundation\Service\Provider as ServiceProvider;

class EditorServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bindShared('editor', function() {
            return new CKEditor();
        });
    }


}