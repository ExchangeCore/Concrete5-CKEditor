<?php
namespace Concrete\Package\CommunityCkeditor;

use Concrete\Core\Foundation\Service\ProviderList;
use Concrete\Core\Package\Package;
use Core;
use Route;

class Controller extends Package
{

    protected $pkgHandle = 'community_ckeditor';
    protected $appVersionRequired = '5.7.5';
    protected $pkgVersion = '0.9.0';

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
        $pkg = parent::install();
        $this->setupDefaultPlugins();
        $this->setupDefaultStyles();
        \SinglePage::add('/dashboard/system/basics/editor/ckeditor_styles', $pkg);
    }

    public function on_start()
    {
        $this->registerRoutes();
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
                'concrete5styles',
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

    public function setupDefaultStyles()
    {
        $prettyPrint = defined('JSON_PRETTY_PRINT') ? JSON_PRETTY_PRINT : 0;

        $this->getConfig()->save(
            'editor.styles',
            json_encode(
                array(
                    array('name' => 'Typewriter', 'element' => 'tt'),
                ),
                $prettyPrint
            )
        );
    }

    protected function registerRoutes()
    {
        Route::register(
            '/package/community_ckeditor/api/styles',
            '\Concrete\Package\CommunityCkeditor\Controller\Api\CkeditorStyles::getStylesList',
            'CommunityCkeditorStylesList'
        );
    }
}
