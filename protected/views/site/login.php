<?php
$this->pageTitle=Yii::t("p","A career management tool").' - '.Yii::t("ui","Login");
$this->pageType='login';
$this->breadcrumbs=array(
	'Login',
	);
?>
<script> var View = "site/login";</script>
<div class="login row">
	<div class="span9">
		<div class="hero-unit">
			<h1><?php echo $this->siteName; ?></h1>
			<p class="<?php echo Yii::app()->language; ?>"><?php echo Yii::t("p","It's a career management tool. Here you can planning your career and follow up it. 
		Track your daily schedule. Manage your own stories in life. 
		If you are a motivated man and want to make a difference, Let's start it immediately!");?>  
			<a class="mlt5" href="/user/register"><?php echo Yii::t("ui","Sign up for an account");?></a></p>
		</div>
	</div>
	<div class="span3">
		<div class="well">
			<h3><?php echo Yii::t("ui","Sign in");?></h3>
			<br />
			<form id="login-form" class="form-horizontal" action="/login" method="post">    
				<div class="control-group">
					<input type="text" name="LoginForm[username]" id="login-username" class="input" value="" placeholder="<?php echo Yii::t("ui","Email or username");?>">
				</div>   
				<div class="control-group">
					<input type="password" name="LoginForm[password]" id="login-password" class="input" placeholder="<?php echo Yii::t("ui","Password");?>">
				</div>
				<div class="control-group">
					<label class="checkbox">
						<input type="checkbox" name="LoginForm[rememberMe]" value="1"> <?php echo Yii::t("ui","Remember me");?>
					</label>
				</div>
				<div class="control-group">
					<button type="submit" class="btn  btn-primary"><?php echo Yii::t("ui","Sign in");?></button> <a  class="mlt5" id="reset-password"><?php echo Yii::t("ui","Forget password？");?></a>
				</div>
				<?php 
					if(isset($model->errors['password'])) 
						echo '<div class="control-group error"><span class="help-inline">* '.Yii::t("ui",$model->errors['password'][0]).'<span></div>'; 
				?> 
			</form>
		</div>
	</div>
	<div class="modal" style="display:none;" id="reset-password-modal">
	  <div class="modal-header">
		<a class="close" data-dismiss="modal">×</a>
		<h3><?php echo Yii::t("ui","Find my password back");?></h3>
	  </div>
		<form id="register-form" class="form-horizontal" action="post">
			<div class="modal-body">
				<div class="control-group">
					<label class="control-label" for="username"><?php echo Yii::t("ui","Please input your email");?></label>
					<div class="controls">
						<input class="input focused"  name="RegisterForm[email]" maxlength="30" type="text" >
					</div>
				</div>
			</div>
		</form>
	  <div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal"><?php echo Yii::t("ui","Cancel");?></a>
		<a href="#" class="btn btn-primary"><?php echo Yii::t("ui","Submit");?></a>
	  </div>
	</div>

</div>

