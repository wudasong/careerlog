<?php $this->pageTitle=Yii::t("p","A career management tool"); ?>
<?php 
	/*
	$cacheKey = 'testing';
	$cacheValue = Yii::app()->cache->get($cacheKey);
	if($cacheValue===false){
		$cacheValue = time();
		Yii::app()->cache->set($cacheKey,$cacheValue,10);
	}
	*/
?>
	  <script> var View = "site/index";</script>
      <div>
        <!-- Todo form  -->
      	<form action="/post/create" class="form-inline" id="publisher">
			<ul class="nav nav-pills">
				<li>
      				<div class="input-prepend">
					   <span class="add-on"><i class="icon-calendar"></i></span><input class="input-small" name="date" value="<?php echo date("Y-m-d"); ?>" size="16" type="text">
					</div>
				</li>
				<li class="dropdown">
				  <a class="dropdown-toggle" data-toggle="dropdown"><span id="category"><?php echo Yii::t("ui","Todo");?></span> <b class="caret"></b></a>
				  <ul class="dropdown-menu">
					<li class="selected" dt="Todo"><a><?php echo Yii::t("ui","Todo");?></a></li>
					<li dt="Note"><a><?php echo Yii::t("ui","Note");?></a></li>
					<li dt="Read"><a><?php echo Yii::t("ui","Read");?></a></li>
					<li dt="Idea"><a><?php echo Yii::t("ui","Idea");?></a></li>
				  </ul>
				</li>
				<li>
					<input type="hidden" value="Todo" name="category">
					<input type="text" class="span4" name="content">
					<!--<span class="content"><textarea rows="5" class="content" name="content1" onpropertychange='this.style.posHeight=this.scrollHeight' onfocus='this.style.posHeight=this.scrollHeight'></textarea></span>-->
      				<button type="submit" class="btn btn-primary"><?php echo Yii::t("ui","Add");?></button>
				</li>
			</ul>
      	</form>
		<div id="posts"></div>
		<!--
      	<h2>2012-04-03</h2>
      	<div class="well">
      		<h3><?php echo Yii::t("ui","Todo");?></h3>
      		<div><input type="checkbox" > Reads the documents of bootstrap CSS framework</div>
      		<div><input type="checkbox" > Fixs the bugs which idea publisher doesn't work</div>
      		<h3><?php echo Yii::t("ui","Note");?></h3>
      		<blockquote>Good good study, day day up!</blockquote>
      		<h3><?php echo Yii::t("ui","Reading");?></h3>
			<div>"Don't make me think"</div>
      	</div>
      	<h2>2012-04-02</h2>
      	<div class="well">
      	<h3><?php echo Yii::t("ui","Todo");?></h3>
      	<div><input type="checkbox" > <span class="label label-important">Fixs the bugs which idea publisher doesn't work</span></div>
      	<h3><?php echo Yii::t("ui","Done");?></h3>
      	<div><input type="checkbox" checked="checked"> <span class="label label-success">Reads the documents of bootstrap CSS framework</span></div>
      	<h3><?php echo Yii::t("ui","Note");?></h3>
      	<blockquote>Good good study, day day up!</blockquote>
      	<blockquote>If you want to do something, just do it!</blockquote>
      	</div>
		<div><span><?php echo CHtml::encode($model['req']); ?></span></div>
		-->
      </div>
	