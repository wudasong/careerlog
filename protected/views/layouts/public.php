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
				</ul>
				<ul class="nav pull-right">
					<li><a href="/login"><?php echo Yii::t("ui","Sign in");?></a></li>
					<li><a href="/user/register"><?php echo Yii::t("ui","Sign up");?></a></li>
				</ul>
			</div><!-- /.nav-collapse -->
			</div>
		</div><!-- /navbar-inner -->
	</div><!-- /navbar -->	
	<div class="container">
		<?php echo $content; ?>
	
	</div>	
	
	<div class="modal" style="display:none;" id="register-modal">
	  <div class="modal-header">
		<a class="close" data-dismiss="modal">×</a>
		<h3><?php echo Yii::t("ui","Sign up for an account");?></h3>
	  </div>
		<form id="reg-form" class="form-horizontal" action="/user/register" method="post">
			<div class="modal-body">
				<fieldset>
					<div class="control-group">
						<label class="control-label" for="username"><?php echo Yii::t("ui","Username");?></label>
						<div class="controls">
							<input class="input focused" name="username" maxlength="30" type="text" tabindex=1 >
						</div>
					</div>
					<div class="control-group">
						<label class="control-label"><?php echo Yii::t("ui","Password");?></label>
						<div class="controls">
							<input type="password" name="password" maxlength="30" class="input" tabindex=2 >
						</div>
					</div>
					<div class="control-group">
						<label class="control-label"><?php echo Yii::t("ui","Password again");?></label>
						<div class="controls">
							<input type="password" name="password2" class="input" maxlength="30" tabindex=3 >
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="username"><?php echo Yii::t("ui","Email");?></label>
						<div class="controls">
							<input class="input focused"  name="email" maxlength="30" type="text" tabindex=4 >
						</div>
					</div>
				</fieldset>
			</div>
		</form>
	  <div class="modal-footer">
		<a class="btn" data-dismiss="modal"><?php echo Yii::t("ui","Cancel");?></a>
		<button id="reg-submit" class="btn btn-primary" tabindex=5><?php echo Yii::t("ui","Submit");?></button>
	  </div>
	</div>
<?php $this->endContent(); ?>