<?php
	$this->pageTitle=Yii::t("ui","Sign up for an account");
?>
<script> var View = "user/register";</script>
<div class="row">
<?php if(!$model['registered']) { ?>
  <div class="span8">
	<form id="reg-form" class="form-horizontal" action="/user/register" method="post">
		<div class="modal-body">
			<fieldset>
				<legend><h2><?php echo Yii::t("ui","Sign up for an account");?></h2></legend>
				<div class="control-group">
					<label class="control-label" for="username"><?php echo Yii::t("ui","Username");?></label>
					<div class="controls">
						<input class="input focused" name="username" maxlength="30" type="text" tabindex=1 value="" >
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
				<div class="form-actions">
					<input type="hidden" value="true" name="RegisterForm" />
					<button type="submit" class="btn btn-primary"  tabindex=5 ><?php echo Yii::t("ui","Submit");?></button>
				</div>
			</fieldset>
		</div>
	  </form>
	</div>
	<?php } else { ?>
	<div class="span8">
		<h3><?php echo Yii::t("p","Congratulation! You have signed up successfully!");?></h3>
		<span><?php echo Yii::t("p","Start it immediately");?></span>
		<span class="mlt5"><a href="/"><?php echo Yii::t("ui","Sign in");?></a></span>
	</div>
	<?php }?>
</div>