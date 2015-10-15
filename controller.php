<?php
namespace Concrete\Package\CommunityCKEditor;

use Concrete\Core\Foundation\Service\ProviderList;
use Concrete\Core\Package\Package;

class Controller extends Package
{

    protected $pkgHandle = 'community_ckeditor';
    protected $appVersionRequired = '5.7.5';
    protected $pkgVersion = '0.1.0';


    public function getPackageName()
    {
        return t('Community CKEditor');
    }

    public function getPackageDescription()
    {
        return t('Overrides the default concrete5 editor with CKEditor');
    }

    public function on_start()
    {
        $this->registerAssets();
        $this->overrideEditor();
    }

    protected function registerAssets()
    {
        $assetList = \AssetList::getInstance();
        $assetList->register(
            'javascript',
            'editor/ckeditor',
            'vendor/ckeditor/ckeditor.js',
            array(),
            $this->pkgHandle
        );
        $assetList->register(
            'javascript',
            'editor/ckeditor/jquery_adapter',
            'vendor/ckeditor/adapters/jquery.js',
            array(),
            $this->pkgHandle
        );

        $assetList->registerGroup(
            'editor/ckeditor',
            [
                ['javascript', 'editor/ckeditor'],
                ['javascript', 'editor/ckeditor/jquery_adapter'],
            ]
        );
    }

    protected function overrideEditor()
    {
        $providers = new ProviderList(\Core::getFacadeRoot());
        $providers->registerProvider('Concrete\Package\CommunityCkeditor\Src\Editor\EditorServiceProvider');
    }
} 