<?php

class PostController extends Controller
{
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' 
					'actions'=>array('index','create','latest','delete','complete'),
					'users'=>array('@'),
				)
			);
	}
	
	/**
	 * Process the create action
	 */
	public function actionCreate()
	{
		$date = $_POST['date'];
		$category = $_POST['category'];
		$content = $_POST['content'];
		
		if(empty($date)||empty($category)||empty($content))
			return;
		
		if(strlen($content) > 500){
			echo 'The length of string : '.strlen($content);
			return;
		}
		
		$setting = '{}';
		$post = new Post();
		$post->user_id = Yii::app()->User->id;
		$post->content= $content;
		$post->category = $category;
		$post->create_date = $date.' '.date("H:i:s");
		$post->setting = $setting;
		$post->save();
		
		echo CJSON::encode($post);
		
		Yii::app()->end();
	}

	/**
	 * Get the post if the user is the post owner
	 *
	 * @param int $id post id
	 * @return post 
	 *
	 */	
	public function getMyPost($id){
		
		$post = Post::model()->findByPk($id);
		
		if($post===null)
			throw new CHttpException(404,'The requested page does not exist.');
		
		if($post->user_id !== Yii::app()->User->id)
			return null;
		
		return $post;
	}

	/**
	 * Process the delete action
	 */
	public function actionDelete()
	{
		$id = $_POST['id'];
		
		$post = $this->getMyPost($id);
		
		if($post!==null)
			$post->delete();
		
		echo CJSON::encode('OK');
		
		Yii::app()->end();
	}

	/**
	 * This is method actionComplete
	 *
	 * @return mixed This is the return value description
	 *
	 */
	public function actionComplete()
	{
		$id = $_POST['id'];
		
		$post = $this->getMyPost($id);
		
		if($post!==null){
			$complete = $_POST['complete'];
			$set = CJSON::decode($post->setting);
			$set['complete'] = $complete;
			$post->setting = CJSON::encode($set);
			$post->update();
		}
		
		echo CJSON::encode('OK');
		
		Yii::app()->end();
	}
	
	
	/**
	 * Get the latest posts 
	 */
	public function actionIndex()
	{
		$user_id = Yii::app()->User->id;
		
		//$date = new DateTime(date('Y-m-d'));
		//$date->sub(new DateInterval('P2D')); // lastet 2 days
		//$start_date = $date->format('Y-m-d');
		
		$posts = Post::model()->findAll(
			array(
					'select'=>'*',
					'condition'=>'user_id = :user_id',
					'order'=> 'create_date DESC',
					'limit'=> 100,
					'params'=>array(
						':user_id'=>$user_id,
						//':start_date'=> $start_date
						),
					)
				);
		
		//$ret = '{date:"'.$start_date.'","posts": '. CJSON::encode($posts) .'}';
		echo  CJSON::encode($posts);
		Yii::app()->end();
	}
	

}