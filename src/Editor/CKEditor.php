<?php
namespace Concrete\Package\CommunityCkeditor\Src\Editor;

use Concrete\Core\Editor\EditorInterface;
use Concrete\Core\Editor\PluginManager;
use Concrete\Core\Http\Request;
use Concrete\Core\Http\ResponseAssetGroup;
use Concrete\Core\Utility\Service\Identifier;
use Core;
use Permissions;

class CKEditor implements EditorInterface
{

    protected $assets;
    protected $identifier;
    protected $token;
    protected $allowFileManager;
    protected $allowSitemap;
    protected $pluginManager;


    public function __construct()
    {
        $fp = new Permissions(\FileSet::getGlobal());
        $tp = new Permissions();

        $this->assets = ResponseAssetGroup::get();
        $this->token = Core::make("token")->generate('editor');
        $this->setAllowFileManager($fp->canAccessFileManager());
        $this->setAllowSitemap($tp->canAccessSitemap());
        $this->pluginManager = new PluginManager();

        //$this->pluginManager->selectMultiple(\Config::get('concrete.editor.plugins.selected'));

    }

    protected function getEditor($key, $content = null, $options = array())
    {
        $this->requireEditorAssets();

        $options = json_encode($options);
        $identifier = id(new Identifier())->getString(32);
        $plugins = $this->pluginManager->getSelectedPlugins();
        $html = sprintf(
            '<div contenteditable="true" id="%s" name="%s">%s</div>',
            $identifier,
            $key,
            $content
        );
        $html .= <<<EOL
        <script type="text/javascript">
        var CCM_EDITOR_SECURITY_TOKEN = "{$this->token}";
        $(function() {
            $('#{$identifier}').ckeditor({$options}).editor
            .on('blur',function(){
                return false;
            })
            .on('remove', function(){
                $(this).destroy();
            });
        });
        </script>
EOL;
        return $html;
    }

    public function outputPageInlineEditor($key, $content = null)
    {
        return $this->getEditor(
            $key,
            $content,
            array(
                'startupFocus' => true,
                'disableAutoInline' => true
            )
        );
    }

    public function outputPageComposerEditor($key, $content)
    {
        // TODO: Implement outputPageComposerEditor() method.
    }

    public function outputBlockEditModeEditor($key, $content)
    {
        // TODO: Implement outputBlockEditModeEditor() method.
    }

    public function outputStandardEditor($key, $content = null)
    {
        // TODO: Implement outputStandardEditor() method.
    }

    public function allowFileManager()
    {
        return $this->allowFileManager;
    }

    public function allowSitemap()
    {
        return $this->allowSitemap;
    }

    public function setAllowFileManager($allow)
    {
        $this->allowFileManager = $allow;
    }

    public function setAllowSitemap($allow)
    {
        $this->allowSitemap = $allow;
    }

    public function getPluginManager()
    {
        return $this->pluginManager;
    }

    public function setPluginManager(PluginManager $pluginManager)
    {
        $this->pluginManager = $pluginManager;
    }

    public function saveOptionsForm(Request $request)
    {
        //todo
        /*\Config::save('ckeditor.enable_filemanager', $request->request->get('enable_filemanager'));
        \Config::save('concrete.editor.concrete.enable_sitemap', $request->request->get('enable_sitemap'));

        $plugins = array();
        $post = $request->request->get('plugin');
        if (is_array($post)) {
            foreach($post as $plugin) {
                if ($this->pluginManager->isAvailable($plugin)) {
                    $plugins[] = $plugin;
                }
            }
        }

        \Config::save('concrete.editor.plugins.selected', $plugins);*/
    }

    public function requireEditorAssets()
    {
        $this->assets->requireAsset('core/file-manager');
        $this->assets->requireAsset('editor/ckeditor');
        $plugins = $this->pluginManager->getSelectedPluginObjects();
        foreach ($plugins as $plugin) {
            $group = $plugin->getRequiredAssets();
            $this->assets->requireAsset($group);
        }
    }
}