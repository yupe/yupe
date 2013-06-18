# Including YiiBooster to your Yii-based web application

Excerpt from the ["Getting Started" section at YiiBooster website](http://yii-booster.clevertech.biz/getting-started.html):

Unzip the extension under `protected/extensions/bootstrap`, the structure of your (Yii's default) application should look like this:

    protected/
    └── extensions
          └── bootstrap
              ├── assets
              │   ├── css
              │   ├── img
              │   ├── js
              │   └── less
              ├── components
              │   Bootstrap.php
              └── widgets
                  └── input

Now, that we have placed the library where it belongs, lets configure the component. On your main.php config file:

    'preload' => array(
        <...>
        'bootstrap',
        <...>
    ),
    'components' => array(
        <...>
        'bootstrap' => array(
            'class' => 'ext.bootstrap.components.Bootstrap',
            'responsiveCss' => true,
        ),
        <...>
    ),
    // YiiBooster includes all the features from its parent
    // project Yii-Bootstrap, thus its gii templates
    'modules' => array(
        <...>
        'gii' => array(
            <...>
            'generatorPaths' => array(
                'bootstrap.gii'
            ),
        ),
        <...>
    ),

The configuration is the same as you do when installing the [Yii-Bootstrap](http://www.yiiframework.com/extension/bootstrap) extension from Chris.
