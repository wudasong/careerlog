<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" lang="<?php echo Yii::app()->language; ?>" >
<![endif]-->
<!--[if IE 7]>
<html id="ie7" lang="<?php echo Yii::app()->language; ?>" >
<![endif]-->
<!--[if IE 8]>
<html id="ie8" lang="<?php echo Yii::app()->language; ?>" >
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html  lang="<?php echo Yii::app()->language; ?>" >
<!--<![endif]-->
<head>
	<meta charset="<?php echo Yii::app()->charset; ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title><?php echo $this->siteName.' - '.$this->pageTitle; ?></title>
	<!-- CSS framework -->
	<link href="/favicon.ico" rel="shortcut icon" type="image/x-icon" />
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.css?v=1">
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-responsive.css?v=1">
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/smoothness/jquery-ui-1.8.2.css">
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css?v=<?php echo $this->siteVersion?>">
	<!--[if lt IE 9]>
	<script src="<?php echo Yii::app()->baseUrl; ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->
</head>

<body class="<?php echo Yii::app()->language.' '.$this->pageType; ?>">
	<?php echo $content; ?>
	<footer>
		<div class="container">
			<hr />
			<div class="pull-left">&copy; <?php echo $this->siteName.' '.date('Y'); ?>. version: <a href="/site/roadmap" class="mrt5"><?php echo $this->siteVersion?></a> by <a href="http://wudasong.com" title="wudasong.com" target="_blank" >wudasong.com</a></div>
			<div class="pull-right"> <?php echo Yii::t("ui","Languages");?>: <a target="_blank" href="http://www.careerlog.cn">简体中文</a> | <a target="_blank" href="http://www.careerlog.org">English</a></div>
		</div>
	</footer>
	<!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.7.2.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui-1.8.2.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js?v=1"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/plugins.js?v=<?php echo $this->siteVersion?>"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lang/<?php echo Yii::app()->language;?>.js?v=<?php echo $this->siteVersion?>"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/site.js?v=<?php echo $this->siteVersion?>"></script>
  </body>
</html>
