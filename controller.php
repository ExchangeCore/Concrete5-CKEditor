<?php
namespace Concrete\Package\CommunityCkeditor;

use Concrete\Core\Editor\Plugin;
use Concrete\Core\Foundation\Service\ProviderList;
use Concrete\Core\Package\Package;
use Core;
use Route;

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
        $assetList->register(
            'css',
            'editor/ckeditor/concrete5inline',
            'assets/concrete5inline/styles.css',
            array(),
            $this->pkgHandle
        );

        $assetList->registerGroup(
            'editor/ckeditor/concrete5inline',
            array(
                array('javascript', 'editor/ckeditor/concrete5inline'),
                array('css', 'editor/ckeditor/concrete5inline')
            )
        );

        $assetList = \AssetList::getInstance();
        $assetList->register(
            'javascript',
            'editor/ckeditor/concrete5filemanager',
            'assets/concrete5filemanager/register.js',
            array(),
            $this->pkgHandle
        );
        $assetList->register(
            'css',
            'editor/ckeditor/concrete5filemanager',
            'assets/concrete5filemanager/styles.css',
            array(),
            $this->pkgHandle
        );
        $assetList->registerGroup(
            'editor/ckeditor/concrete5filemanager',
            array(
                array('javascript', 'editor/ckeditor/concrete5filemanager'),
                array('css', 'editor/ckeditor/concrete5filemanager'),
            )
        );

        $assetList = \AssetList::getInstance();
        $assetList->register(
            'javascript',
            'editor/ckeditor/concrete5uploadimage',
            'assets/concrete5uploadimage/register.js',
            array(),
            $this->pkgHandle
        );
        $assetList->registerGroup(
            'editor/ckeditor/concrete5uploadimage',
            array(
                array('javascript', 'editor/ckeditor/concrete5uploadimage'),
            )
        );

        $pluginManager = Core::make('editor')->getPluginManager();

        $plugin = new Plugin();
        $plugin->setKey('concrete5inline');
        $plugin->setName(t('Concrete5 Inline'));
        $plugin->requireAsset('editor/ckeditor/concrete5inline');
        $pluginManager->register($plugin);

        $plugin = new Plugin();
        $plugin->setKey('concrete5filemanager');
        $plugin->setName(t('Concrete5 File Browser'));
        $plugin->requireAsset('editor/ckeditor/concrete5filemanager');
        $pluginManager->register($plugin);

        $plugin = new Plugin();
        $plugin->setKey('concrete5uploadimage');
        $plugin->setName(t('Concrete5 Upload Image'));
        $plugin->requireAsset('editor/ckeditor/concrete5uploadimage');
        $pluginManager->register($plugin);
    }

    protected function registerInternalPlugins()
    {
        $pluginList = array(
            array('key' => 'about', 'name' => t('About')),
            array('key' => 'a11yhelp', 'name' => t('Accessibility Help')),
            array('key' => 'basicstyles', 'name' => t('Basic Styles')),
            array('key' => 'bidi', 'name' => t('BiDi (Text Direction)')),
            array('key' => 'blockquote', 'name' => t('Blockquote')),
            array('key' => 'clipboard', 'name' => t('Clipboard')),
            array('key' => 'codesnippet', 'name' => t('Code Snippet')),
            array('key' => 'colorbutton', 'name' => t('Color Button')),
            array('key' => 'colordialog', 'name' => t('Color Dialog')),
            array('key' => 'contextmenu', 'name' => t('Context Menu')),
            array('key' => 'dialogadvtab', 'name' => t('Advanced Tab for Dialogs')),
            array('key' => 'div', 'name' => t('Div Container Manager')),
            array('key' => 'divarea', 'name' => t('Div Editing Area')),
            array('key' => 'elementspath', 'name' => t('Elements Path')),
            array('key' => 'embed', 'name' => t('Media Embed')),
            array('key' => 'enterkey', 'name' => t('Enter Key')),
            array('key' => 'entities', 'name' => t('Escape HTML Entities')),
            array('key' => 'find', 'name' => t('Find / Replace')),
            array('key' => 'flash', 'name' => t('Flash Dialog')),
            array('key' => 'floatingspace', 'name' => t('Floating Space')),
            array('key' => 'font', 'name' => t('Font Size and Famiy')),
            array('key' => 'format', 'name' => t('Format')),
            array('key' => 'forms', 'name' => t('Form Elements')),
            array('key' => 'horizontalrule', 'name' => t('Horizontal Rule')),
            array('key' => 'htmlwriter', 'name' => t('HTML Output Writer')),
            array('key' => 'image', 'name' => t('Image')), //todo: integrate/replace with concrete5 file manager
            array('key' => 'image2', 'name' => t('Enhanced Image')),
            array('key' => 'indentblock', 'name' => t('Indent Block')),
            array('key' => 'indentlist', 'name' => t('Indent List')),
            array('key' => 'justify', 'name' => t('Justify')),
            array('key' => 'language', 'name' => t('Language')),
            array('key' => 'link', 'name' => t('Link')), //todo: integrate/replace with sitemap support
            array('key' => 'list', 'name' => t('List')),
            array('key' => 'liststyle', 'name' => t('List Style')),
            array('key' => 'magicline', 'name' => t('Magic Line')),
            array('key' => 'maximize', 'name' => t('Maximize')),
            array('key' => 'newpage', 'name' => t('New Page')),
            array('key' => 'pagebreak', 'name' => t('Page Break')),
            array('key' => 'pastetext', 'name' => t('Paste As Plain Text')),
            array('key' => 'pastefromword', 'name' => t('Paste from Word')),
            array('key' => 'placeholder', 'name' => t('Placeholder')),
            array('key' => 'preview', 'name' => t('Preview')),
            array('key' => 'removeformat', 'name' => t('Remove Format')),
            array('key' => 'resize', 'name' => t('Editor Resize')),
            array('key' => 'scayt', 'name' => t('SpellCheckAsYouType (SCAYT)')),
            array('key' => 'selectall', 'name' => t('Select All')),
            array('key' => 'showblocks', 'name' => t('Show Blocks')),
            array('key' => 'showborders', 'name' => t('Show Table Borders')),
            array('key' => 'smiley', 'name' => t('Insert Smiley')),
            array('key' => 'sourcearea', 'name' => t('Source Editing Area')),
            array('key' => 'sourcedialog', 'name' => t('Source Dialog')),
            array('key' => 'specialchar', 'name' => t('Special Characters')),
            array('key' => 'stylescombo', 'name' => t('Styles Combo')),
            array('key' => 'tab', 'name' => t('Tab Key Handling')),
            array('key' => 'table', 'name' => t('Table')),
            array('key' => 'tableresize', 'name' => t('Table Resize')),
            array('key' => 'tabletools', 'name' => t('Table Tools')),
            array('key' => 'templates', 'name' => t('Content Templates')),
            array('key' => 'toolbar', 'name' => t('Editor Toolbar')),
            array('key' => 'undo', 'name' => t('Undo')),
            array('key' => 'wsc', 'name' => t('WebSpellChecker')),
            array('key' => 'wysiwygarea', 'name' => t('IFrame Editing Area')),
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
        $this->getConfig()->save(
            'plugins',
            array(
                'a11yhelp',
                'basicstyles',
                'colorbutton',
                'colordialog',
                'contextmenu',
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
