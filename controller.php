<?php
namespace Concrete\Package\CommunityCKEditor;

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
            array(
                array('javascript', 'editor/ckeditor'),
                array('javascript', 'editor/ckeditor/jquery_adapter')
            )
        );

        $providers = new ProviderList(\Core::getFacadeRoot());
        $providers->registerProvider('Concrete\Package\CommunityCkeditor\Src\Editor\EditorServiceProvider');
        $this->registerInlinePlugin();
        $this->registerInternalPlugins();
    }

    protected function registerInlinePlugin()
    {
        $assetList = \AssetList::getInstance();
        $assetList->register(
            'javascript',
            'editor/ckeditor/concrete5inline',
            'assets/concrete5inline/register.js',
            array(),
            $this->pkgHandle
        );

        $assetList->registerGroup(
            'editor/ckeditor/concrete5inline',
            array(
                array('javascript', 'editor/ckeditor/concrete5inline')
            )
        );

        $plugin = new Plugin();
        $plugin->setKey('concrete5inline');
        $plugin->setName(t('Concrete5 Inline'));
        $plugin->requireAsset('editor/ckeditor/concrete5inline');
        Core::make('editor')->getPluginManager()->register($plugin);
    }

    protected  function registerInternalPlugins()
    {
        $pluginList = array(
            array('key' => 'about', 'name' => t('About')),
            array('key' => 'basicstyles', 'name' => t('Basic Styles')),
            array('key' => 'clipboard', 'name' => t('Clipboard')),
            array('key' => 'toolbar', 'name' => t('Editor Toolbar')),
            array('key' => 'enterkey', 'name' => t('Enter Key')),
            array('key' => 'entities', 'name' => t('Escape HTML Entities')),
            array('key' => 'floatingspace', 'name' => t('Floating Space')),
            array('key' => 'wysiwygarea', 'name' => t('IFrame Editing Area')),
            array('key' => 'indentlist', 'name' => t('Indent List')),
            array('key' => 'link', 'name' => t('Link')),
            array('key' => 'list', 'name' => t('List')),
            array('key' => 'undo', 'name' => t('Undo')),
            array('key' => 'a11yhelp', 'name' => t('Accessibility Help')),
            array('key' => 'blockquote', 'name' => t('Blockquote')),
            array('key' => 'contextmenu', 'name' => t('Context Menu')),
            array('key' => 'resize', 'name' => t('Editor Resize')),
            array('key' => 'elementspath', 'name' => t('Elements Path')),
            //array('key' => 'filebrowser', 'name' => t('File Browser')), todo: implement concrete5 file manager
            array('key' => 'format', 'name' => t('Format')),
            array('key' => 'horizontalrule', 'name' => t('Horizontal Rule')),
            array('key' => 'htmlwriter', 'name' => t('HTML Output Writer')),
            array('key' => 'image', 'name' => t('Image')), //todo: integrate/replace with concrete5 file manager
            array('key' => 'magicline', 'name' => t('Magic Line')),
            array('key' => 'maximize', 'name' => t('Maximize')),
            array('key' => 'pastetext', 'name' => t('Paste As Plain Text')),
            array('key' => 'pastefromword', 'name' => t('Paste from Word')),
            array('key' => 'removeformat', 'name' => t('Remove Format')),
            array('key' => 'showborders', 'name' => t('Show Table Borders')),
            array('key' => 'sourcearea', 'name' => t('Source Editing Area')),
            array('key' => 'specialchar', 'name' => t('Special Characters')),
            array('key' => 'scayt', 'name' => t('SpellCheckAsYouType (SCAYT)')),
            array('key' => 'stylescombo', 'name' => t('Styles Combo')),
            array('key' => 'tab', 'name' => t('Tab Key Handling')),
            array('key' => 'table', 'name' => t('Table')),
            array('key' => 'tabletools', 'name' => t('Table Tools')),
            array('key' => 'wsc', 'name' => t('WebSpellChecker')),
            array('key' => 'dialogadvtab', 'name' => t('Advanced Tab for Dialogs')),
            array('key' => 'bidi', 'name' => t('BiDi (Text Direction)')),
            array('key' => 'colorbutton', 'name' => t('Color Button')),
            array('key' => 'colordialog', 'name' => t('Color Dialog')),
            array('key' => 'templates', 'name' => t('Content Templates')),
            array('key' => 'div', 'name' => t('Div Container Manager')),
            array('key' => 'find', 'name' => t('Find / Replace')),
            array('key' => 'flash', 'name' => t('Flash Dialog')),
            array('key' => 'font', 'name' => t('Font Size and Famiy')),
            array('key' => 'forms', 'name' => t('Form Elements')),
            array('key' => 'iframe', 'name' => t('IFrame Dialog')),
            array('key' => 'indentblock', 'name' => t('Indent Block')),
            array('key' => 'smiley', 'name' => t('Insert Smiley')),
            array('key' => 'justify', 'name' => t('Justify')),
            array('key' => 'language', 'name' => t('Language')),
            array('key' => 'liststyle', 'name' => t('List Style')),
            array('key' => 'newpage', 'name' => t('New Page')),
            array('key' => 'pagebreak', 'name' => t('Page Break')),
            array('key' => 'preview', 'name' => t('Preview')),
            array('key' => 'selectall', 'name' => t('Select All')),
            array('key' => 'showblocks', 'name' => t('Show Blocks')),
        );

        foreach ($pluginList as $plugin) {
            $editorPlugin = new Plugin();
            $editorPlugin->setKey($plugin['key']);
            $editorPlugin->setName($plugin['name']);
            Core::make('editor')->getPluginManager()->register($editorPlugin);
        }
    }

    protected function setupDefaultPlugins()
    {
        $this->getConfig()->save('plugins',
            array(
                'basicstyles',
                'clipboard',
                'tab',
                'htmlwriter',
                'toolbar',
                'enterkey',
                'entities',
                'floatingspace',
                'format',
                'sourcearea',
                'wysiwygarea',
                'indentlist',
                'link',
                'list',
                'undo'
            )
        );
    }
} 