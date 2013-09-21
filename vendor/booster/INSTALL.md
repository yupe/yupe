# Installing instructions

## 1. Attaching to Yii application

Write the following to your application config:

    'components' => array(
        'bootstrap' => array(
            'class' => 'aliased.path.to.booster.directory.and.inside.it.Bootstrap.class'
        )
    ),

Of course it has to be inside your existing `components` section, do not create second one.

Name of component _must_ be `bootstrap`, please bear with it for now.

See the `components/Bootstrap.php` file for configuration properties of Bootstrap component.

## 2. Setting up initialization

You have two options.

Lazy way is to preload YiiBooster at every request. Write the following inside your application config:

    'preload' => array(
        ... possibly other components to be preloaded ...
        'booster'
    ),

As with `components` section above, do not create another `preload` section if you already have one.

Precise way is to use the custom filter shipped with YiiBooster, to load `Bootstrap` component only on chosen Controller actions.
You have to write something like this inside each Controller you want to have YiiBooster loaded:

    public function filters() {
        return array(
            ... probably other filter specifications ...
            array('path.alias.to.bootstrap.filters.BootstrapFilter - delete')
        );
    }

`.filters.BootstrapFilter` snippet has to be written verbatim - it is the path to subfolder under the YiiBooster directory.

This example declaration will tell the Controller in question to load `Bootstrap` component on any action except `delete` one.
You can look at the [documentation for CController.filters() method](http://www.yiiframework.com/doc/api/CController#filters-detail)
for details about using this feature.

## That's all

Now you can call widgets included in YiiBooster using the following incantation in your view files:

    $this->widget('bootstrap.widgets.TbWidgetClassName', $config);

Where `WidgetClassName` placeholder stands for name of the widget.
All YiiBooster widget classes are prefixed by `Tb` by convention.

Automatically-generated alias `bootstrap` points to the directory which holds `widgets` folder inside your YiiBooster installation.



