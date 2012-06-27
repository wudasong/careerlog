<?php

class UserController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','register','check','profile'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
					'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	/**
	 * Displays the profile of the user
	 */
	public function actionProfile()
	{		
		$req='';
		if(isset($_GET['req']))
			$req = $_GET['req'];
		
		$this->render('profile',array(
			'model'=> array('username'=> $req) ,
			));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	
	/**
	* Checks if there is a same username or email.
	*/
	public function actionCheck()
	{
		$result = $this->checkRegisterField();
		echo CJSON::encode($result);
		Yii::app()->end();
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionRegister($id = 0)
	{
		$model = array('registered'=>$id);
		if(isset($_POST['RegisterForm']))
		{
			$username = $_POST['username'];
			$password = $_POST['password'];
			$email = $_POST['email'];
			
			if(empty($username)||empty($password)||empty($email))
				return;
			
			$ret = $this->checkRegisterField();
			if($ret['isvalid']===true)
			{
				$user = new User();
				$user->username = $username;
				$user->password = md5($password);
				$user->email = $email;
				$user->status = 1;
				$user->save();
				
				// login the registered user
				$identity = new UserIdentity($user->username,$user->password);
				Yii::app()->user->login($identity,3600);
			}
			
			$this->redirect('/user/register/1');
		}
		
		// display the register form
		$this->render('register',array('model'=>$model));
		
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new User;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('User');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	/**
	 * Checks if the register fields valid 
	 */
	protected function checkRegisterField()
	{
		$result = array('isvalid'=>true);
		
		if(isset($_POST['username']))
		{
			$username = $_POST['username'];
			$user = User::model()->find('username=:username', array(':username'=>$username));
			if(isset($user->username))
			{
				$result['isvalid'] = false;
				$result['error'] = Yii::t('p', 'Someone already has that username.');
			}
		}
		
		if(isset($_POST['email']))
		{
			$email = $_POST['email'];
			$user = User::model()->find('email=:email', array(':email'=>$email));
			if(isset($user->email))
			{
				$result['isvalid'] = false;
				$result['error'] = Yii::t('p', 'That email had been used before.');
			}
		}
		
		return $result;
	}
}
