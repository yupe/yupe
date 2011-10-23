<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="en"/>

    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css"
          media="screen, projection"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css"
          media="print"/>
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css"
          media="screen, projection"/>
    <![endif]-->

    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css"/>

    <style>
        body {
            background: white;
            font-family: 'Lucida Grande', Verdana, Geneva, Lucida, Helvetica, Arial, sans-serif;
            font-size: 10pt;
            font-weight: normal;
        }

        #page {
            width: 800px;
            margin: 0 auto;
        }

        #header {
        }

        #content {
        }

        #footer {
            color: gray;
            font-size: 8pt;
            border-top: 1px solid #aaa;
            margin-top: 10px;
        }

        h1 {
            color: black;
            font-size: 1.6em;
            font-weight: bold;
            margin: 0.5em 0pt;
        }

        h2 {
            color: black;
            font-size: 1.25em;
            font-weight: bold;
            margin: 0.3em 0pt;
        }

        h3 {
            color: black;
            font-size: 1.1em;
            font-weight: bold;
            margin: 0.2em 0pt;
        }

        table.result {
            background: #E6ECFF none repeat scroll 0% 0%;
            border-collapse: collapse;
            width: 100%;
        }

        table.result th {
            background: #CCD9FF none repeat scroll 0% 0%;
            text-align: left;
        }

        table.result th, table.result td {
            border: 1px solid #BFCFFF;
            padding: 0.2em;
        }

        td.passed {
            background-color: #60BF60;
            border: 1px solid silver;
            padding: 2px;
        }

        td.warning {
            background-color: #FFFFBF;
            border: 1px solid silver;
            padding: 2px;
        }

        td.failed {
            background-color: #FF8080;
            border: 1px solid silver;
            padding: 2px;
        }
    </style>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

    <div id="header">
        <div id="logo"><?php echo Yii::t('install', 'Установка');?> <?php echo CHtml::encode(Yii::app()->name); ?>
             <br/> <br/><?php echo CHtml::encode($this->stepName);?></div>
    </div>
    <!-- header -->
    <div id="mainmenu">

    </div>
    <!-- mainmenu -->

    <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                                                         'links' => $this->breadcrumbs,
                                                    )); ?><!-- breadcrumbs -->

    <?php $this->widget('YFlashMessages');?>

    <div class="container">
        <div class="span-19">
            <div id="content">
                <?php echo $content; ?>
            </div>
            <!-- content -->
        </div>
        <div class="span-5 last">
            <div id="sidebar">
                <?php

                $this->beginWidget('zii.widgets.CPortlet', array('title' => ''));
                $this->widget('zii.widgets.CMenu', array(
                                                        'items' => $this->menu,
                                                        'htmlOptions' => array('class' => 'operations'),
                                                   ));
                $this->endWidget();
                ?>
            </div>
            <!-- sidebar -->
        </div>
    </div>


    <div id="footer">
        Copyright &copy; 2009-<?php echo date('Y'); ?> <br/>
        <?php echo Yii::powered(); ?>
    </div>
    <!-- footer -->

</div>
<!-- page -->
</body>

</html>
