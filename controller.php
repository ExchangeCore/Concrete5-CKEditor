<?php
namespace Concrete\Package\CommunityCkeditor;

use Concrete\Core\Editor\Plugin;
use Concrete\Core\Foundation\Service\ProviderList;
use Concrete\Core\Package\Package;
use Core;

class Controller extends Package
{

    protected $pkgHandle = 'community_ckeditor';
    protected $appVersionRequired = '5.7.5';
    protected $pkgVersion = '0.1.1';

    public function getPackageName()
    {
        return t('Community CKEditor');
    }

    public function getPackageDescription()
    {
        return t('Overrides the default concrete5 editor with CKEditor');
    }

    public function install()
    {
        parent::install();
        $this->setupDefaultPlugins();
    }

    public function on_start()
    {
        $this->overrideEditor();
    }

    protected function overrideEditor()
    {
        $providers = new ProviderList(\Core::getFacadeRoot());
        $providers->registerProvider('Concrete\Package\CommunityCkeditor\Src\Editor\EditorServiceProvider');
    }

    protected function setupDefaultPlugins()
    {
        $this->getConfig()->save(
            'plugins',
            array(
                'a11yhelp',
                'basicstyles',
                'colorbutton',
                'colordialog',
                'contextmenu',
                'concrete5link',
                'dialogadvtab',
                'divarea',
                'elementspath',
                'enterkey',
                'entities',
                'floatingspace',
                'font',
                'format',
                'htmlwriter',
                'image',
                'image2',
                'indentblock',
                'indentlist',
                'justify',
                'link',
                'list',
                'liststyle',
                'magicline',
                'removeformat',
                'resize',
                'showblocks',
                'showborders',
                'sourcearea',
                'sourcedialog',
                'stylescombo',
                'tab',
                'table',
                'tableresize',
                'tabletools',
                'toolbar',
                'undo',
                'wysiwygarea'
            )
        );
    }
}
