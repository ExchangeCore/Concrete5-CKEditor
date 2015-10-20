# Plugin Guide

In this guide we will outline how to create a plugin which is available to be used with the community CKEditor package.

## Creating a CKEditor Plugin

Since CKEditor already has a guide on how to create a plugin we'll just point you at 
[their documentation](http://docs.ckeditor.com/#!/guide/plugin_sdk_sample_1). However, you should not place your plugin
within the CKEditor vender folder in this package we'll show you how to set that up in the next step here.

## Creating a package for your plugin

In our example we will create a package called "Example CKEditor Plugin". So to start we'll need the following:

### /packages/example_ckeditor_plugin/assets/example_editor_plugin/plugin.js

```js
CKEDITOR.plugins.add( 'example_editor_plugin', {
    init: function( editor ) {
        alert("THIS IS AN EXAMPLE");
        // Plugin logic goes here...
    }
});
```

### /packages/example_ckeditor_plugin/assets/example_editor_plugin/register.js

The register.js file is in charge of telling CKEditor where our `example_editor_plugin` resides. We need this because
CKEditor loads all of the plugin assets on it's own, it just needs to be told what plugins to load. This file allows us
to associate a plugin key to a specific path. Notice this is not something you normally need for most standard CKEditor
plugins, this is something we're adding so that we can get a CKEditor plugin, to work with the concrete5 asset manager.

```js
CKEDITOR.plugins.addExternal(
    'concrete5inline', 
    CCM_REL + '/packages/example_editor_plugin/assets/example_editor_plugin/'
);
```

### /packages/example_ckeditor_plugin/controller.php

Finally we set up our package controller. In the on_start we register our 

```php
<?php
namespace Concrete\Package\ExampleCkeditorPlugin;

use Concrete\Core\Editor\Plugin;
use Core;

class Controller extends Package
{

    protected $pkgHandle = 'example_ckeditor_plugin';
    protected $appVersionRequired = '5.7.5';
    protected $pkgVersion = '0.9.0';


    public function getPackageName()
    {
        return t('Example CKEditor Plugin');
    }

    public function getPackageDescription()
    {
        return t('A Simple CKEditor Example Plugin');
    }
    
    public function on_start()
    {
        $this->registerPlugin();
    }
    
    protected function registerPlugin()
    {        
        $assetList = \AssetList::getInstance();
        //register our register.js asset
        $assetList->register(
            'javascript',
            'editor/ckeditor/example_ckeditor_plugin',
            'assets/example_ckeditor_plugin/register.js',
            array(),
            $this->pkgHandle
        );

        //add our register.js asset to a group
        $assetList->registerGroup(
            'editor/ckeditor/example_ckeditor_plugin',
            array(
                array('javascript', 'editor/ckeditor/example_ckeditor_plugin')
            )
        );
        
        //associate our register.js group to the plugin
        $plugin = new Plugin();
        $plugin->setKey('example_ckeditor_plugin');
        $plugin->setName(t('Example CKEditor Plugin'));
        $plugin->requireAsset('example_ckeditor_plugin'); 
        Core::make('editor')->getPluginManager()->register($plugin);
    }
} 
```