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
        $this->pluginManager->selectMultiple(
            \Package::getByHandle('community_ckeditor')->getConfig()->get('plugins', array())
        );

    }

    protected function getEditorScript($identifier, $options = array())
    {
        $this->requireEditorAssets();
        $plugins = $this->pluginManager->getSelectedPlugins();
        $options = array_merge(
            $options,
            array(
                'plugins' => implode(',', $plugins),
            )
        );
        $options = json_encode($options);
        $html = <<<EOL
        <script type="text/javascript">
        var CCM_EDITOR_SECURITY_TOKEN = "{$this->token}";
        $(function() {
            var ckeditor = $('#{$identifier}').ckeditor({$options}).editor;
            ckeditor.on('blur',function(){
                return false;
            });
            ckeditor.on('remove', function(){
                $(this).destroy();
            });
        });
        </script>
EOL;
        return $html;
    }

    public function outputPageInlineEditor($key, $content = null)
    {
        $identifier = id(new Identifier())->getString(32);
        $this->getPluginManager()->select('concrete5inline');
        $html = sprintf(
            '<textarea id="%s_content" style="display:none;" name="%s"></textarea>
            <div contenteditable="true" id="%s">%s</div>',
            $identifier,
            $key,
            $identifier,
            $content
        );
        $html .= $this->getEditorScript($identifier, array(
                'startupFocus' => true,
                'disableAutoInline' => true
            )
        );
        return $html;
    }

    public function outputPageComposerEditor($key, $content)
    {
        return $this->outputStandardEditor($key, $content);
    }

    public function outputBlockEditModeEditor($key, $content)
    {
        return $this->outputStandardEditor($key, $content);
    }

    public function outputStandardEditor($key, $content = null)
    {
        $identifier = id(new Identifier())->getString(32);
        $html = sprintf(
            '<textarea id="%s" style="display:none;" name="%s">%s</textarea>',
            $identifier,
            $key,
            $content
        );
        $html .= $this->getEditorScript($identifier, array(
                'startupFocus' => true,
                'disableAutoInline' => true
            )
        );
        return $html;
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
        \Config::save('concrete.editor.concrete.enable_filemanager', $request->request->get('enable_filemanager'));
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

        \Package::getByHandle('community_ckeditor')->getConfig()->save('plugins', $plugins);
    }

    public function requireEditorAssets()
    {
        //$this->assets->requireAsset('core/file-manager'); todo: still need to make this work
        $this->assets->requireAsset('editor/ckeditor');
        $plugins = $this->pluginManager->getSelectedPluginObjects();
        foreach ($plugins as $plugin) {
            $group = $plugin->getRequiredAssets();
            $this->assets->requireAsset($group);
        }
    }
}