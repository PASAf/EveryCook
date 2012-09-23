<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	public function actionAdmin()
	{
		$this->useDefaultMainButtons();
		$this->checkRenderAjax('admin');
	}
	
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		if (!$this->getIsAjaxRequest() && isset(Yii::app()->session['ajaxSession']) && Yii::app()->session['ajaxSession']){
			$this->layout='//layouts/main';
			$this->checkRenderAjax('empty');
		} else {
			$this->useDefaultMainButtons();
			// renders the view file 'protected/views/site/index.php'
			// using the default layout 'protected/views/layouts/main.php'
			
			$index=0;
			$command = Yii::app()->db->createCommand()
					->from('recipes')
					->order('CHANGED_ON desc')
					->limit(1,$index);
			$recipe = $command->queryRow();
			
			$command = Yii::app()->db->createCommand()
					->from('ingredients')
					->order('CHANGED_ON desc')
					->limit(1,$index);
			$ingredient = $command->queryRow();
			
			$command = Yii::app()->db->createCommand()
					->from('products')
					->order('CHANGED_ON desc')
					->limit(1,$index);
			$product = $command->queryRow();
			
			$this->checkRenderAjax('index', array(
				'recipe'=>$recipe,
				'ingredient'=>$ingredient,
				'product'=>$product,
			));
		}
	}
	
	public function actionGetNext($type, $index){
		if ($type == 'recipe' || $type == 'ingredient' || $type == 'product'){
			if ($index<0){
				$command = Yii::app()->db->createCommand()
					->select('count(*)')
					->from($type.'s');
				$amount = $command->queryScalar();
				$index = $amount-1;
			}
			$command = Yii::app()->db->createCommand()
					->from($type.'s')
					->order('CHANGED_ON desc')
					->limit(1,$index);
			$model = $command->queryRow();
			if (!isset($model) || $model == null){
				$index = 0;
				$command = Yii::app()->db->createCommand()
						->from($type.'s')
						->order('CHANGED_ON desc')
						->limit(1,$index);
				$model = $command->queryRow();
			}
			
			if ($type == 'recipe'){
				echo '{img:"'.$this->createUrl('recipes/displaySavedImage', array('id'=>$model['REC_ID'], 'ext'=>'.png')).'", url:"'.Yii::app()->createUrl('recipes/view', array('id'=>$model['REC_ID'])).'", auth:"'.$model['REC_IMG_AUTH'].'", name:"'.$model['REC_NAME_' . Yii::app()->session['lang']].'", index: '.$index.'}';
			} else if ($type == 'ingredient'){
				echo '{img:"'.$this->createUrl('ingredients/displaySavedImage', array('id'=>$model['ING_ID'], 'ext'=>'.png')).'", url:"'.Yii::app()->createUrl('ingredients/view', array('id'=>$model['ING_ID'])).'", auth:"'.$model['ING_IMG_AUTH'].'", name:"'.$model['ING_NAME_' . Yii::app()->session['lang']].'", index: '.$index.'}';
			} else if ($type == 'product'){
				echo '{img:"'.$this->createUrl('products/displaySavedImage', array('id'=>$model['PRO_ID'], 'ext'=>'.png')).'", url:"'.Yii::app()->createUrl('products/view', array('id'=>$model['PRO_ID'])).'", auth:"'.$model['PRO_IMG_CR'].'", name:"'.$model['PRO_NAME_' . Yii::app()->session['lang']].'", index: '.$index.'}';
			}
		}
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		$this->useDefaultMainButtons();
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		//echo $error['message'];
				$this->checkRenderAjax('error', $error);
	    	else
	        	$this->checkRenderAjax('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$this->useDefaultMainButtons();
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->checkRenderAjax('contact',array('model'=>$model));
	}
	
	public function actionCloseBrowserError(){
		Yii::app()->session['browserErrorClosed'] = true;
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()){
				if (substr(Yii::app()->user->returnUrl,-10) == '/index.php'){
					$this->showLastAction();
				} else {
					$this->redirect(Yii::app()->user->returnUrl);
				}
			}
		}
		// display the login form
		$this->checkRenderAjax('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}