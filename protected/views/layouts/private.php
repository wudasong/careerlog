<?php $this->beginContent('//layouts/main'); ?>	
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<a class="brand" href="/"><?php echo $this->siteName; ?></a>
			<div class="nav-collapse">
				<ul class="nav">
				<li class="active"><a href="/"><?php echo Yii::t("ui","Home");?></a></li>
				<li><a href="/"><?php echo Yii::t("ui","Calendar");?></a></li>
				<li><a href="/"><?php echo Yii::t("ui","Notebooks");?></a></li>
				<li><a href="/"><?php echo Yii::t("ui","Knowledge");?></a></li>
				<li><a href="/"><?php echo Yii::t("ui","Planning");?></a></li>
				<!--<li><a href="/"><?php echo Yii::t("ui","Mycareer");?></a></li>
				<li><a href="/"><?php echo Yii::t("ui","Log");?></a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo Yii::t("ui","Applications");?> <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="/"><?php echo Yii::t("ui","Books");?></a></li>
						<li><a href="/"><?php echo Yii::t("ui","Finance");?></a></li>
						<li><a href="/"><?php echo Yii::t("ui","Knowledge");?></a></li>
						<li class="divider"></li>
						<li><a href="/"><?php echo Yii::t("ui","More Applications");?></a></li>
						<li><a href="/"><?php echo Yii::t("ui","Management");?></a></li>
					</ul>
				</li>-->
				</ul>
				<ul class="nav pull-right">
				<!-- 
				<li><a href="/">Link</a></li>
				-->
				<form class="navbar-search pull-left" name="search" action="post">
					<input type="text" class="search-query span2" placeholder="<?php echo Yii::t("ui","Search");?>" />
				</form>
				<li class="divider-vertical"></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo Yii::app()->User->name; ?><b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="/"><i class="icon-envelope"></i> <?php echo Yii::t("ui","Messages");?> </a></li>
						<li><a href="/<?php echo Yii::app()->User->name; ?>"><i class="icon icon-user"></i> <?php echo Yii::t("ui","Profile");?></a></li>
						<!--
						<li><a href="/"><?php echo Yii::t("ui","Contacts");?> </a></li>
						-->
						<li><a href="/"><i class="icon-cog"></i> <?php echo Yii::t("ui","Settings");?></a></li>
						<li class="divider"></li>
						<li><a href="/logout"><i class="icon-off"></i> <?php echo Yii::t("ui","Logout");?></a></li>
					</ul>
				</li>
				</ul>
			</div><!-- /.nav-collapse -->
			</div>
		</div><!-- /navbar-inner -->
	</div><!-- /navbar -->	
	<div class="container">
	<?php echo $content; ?>
	</div>
<?php $this->endContent(); ?>