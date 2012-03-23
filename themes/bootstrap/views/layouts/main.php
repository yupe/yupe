<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="<?php echo Yii::app()->language;?>"/>
    <meta name="keywords" content="<?php echo $this->keywords;?>"/>
    <meta name="description" content="<?php echo $this->description;?>"/> 
    <link rel="stylesheet" type="text/css"  href="<?php echo Yii::app()->theme->baseUrl; ?>/bootstrap/css/bootstrap.min.css"/> 
    <link rel="stylesheet" type="text/css"  href="<?php echo Yii::app()->theme->baseUrl; ?>/bootstrap/css/bootstrap-responsive.min.css"/>     
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<?php $this->widget('application.modules.page.widgets.PagesWidget');?>

<div class="container">    

    <div class="hero-unit">
        <h1><?php echo CHtml::encode(Yii::app()->getModule('yupe')->siteName); ?></h1>
        <p><?php echo CHtml::encode(Yii::app()->getModule('yupe')->siteDescription); ?></p>
        <p><a class="btn btn-primary btn-large">Узнать больше &raquo;</a></p>
    </div>           
    
  <div class="row">
    <div class="span4">
      <h2>Heading</h2>
       <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
      <p><a class="btn" href="#">View details &raquo;</a></p>
    </div>
    <div class="span4">
      <h2>Heading</h2>
       <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
      <p><a class="btn" href="#">View details &raquo;</a></p>
   </div>
    <div class="span4">
      <h2>Heading</h2>
      <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
      <p><a class="btn" href="#">View details &raquo;</a></p>
    </div>
  </div>
   
  <hr/>     

  <footer>        
    <p>Copyright &copy; 2009-<?php echo date('Y'); ?> <a href='http://yupe.ru?from=engine'>Юпи!</a></p>
  </footer>

</div>
<!-- page -->

</body>

</html>
