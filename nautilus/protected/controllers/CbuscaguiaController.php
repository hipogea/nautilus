<?php

class CbuscaguiaController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function accessRules()
	{
		return array(			
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('Filtraguia'),
				'users'=>array('*'),
			),
			);
		
		
	}


	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionFiltraguia()
	{
		$model=new Cbuscaguia;
		if(isset($_POST['Cbuscaguia'] ))
		{
		
		  if(isset($_POST['Cbuscaguia'] )  or isset($_POST['VwGuia'] ) )
							$model->attributes=$_POST['VwGuia'];
								if($model->validate())
													{
														$modeloguia= new VwGuia;
														$criteriazo=new CDbCriteria;
														$attributes=$model->attributeNames(); 
														foreach($attributes as $value) 
														{ 
																if(!isset($value))  {
																//Si tiene filtro	
																if (!($value=='d_fectra1') )
																		$criteriazo->compare($value,$modeloguia->$$value);
																}
																				
														} 
														$proveedor = new CActiveDataProvider($modeloguia, array(
															'criteria'=>$criteriazo,
																	));		
																$this->render('admin',array('model'=>$modeloguia,'proveedor'=>$proveedor));	
													}
		}
		$this->render('_filtraguia',array('model'=>$model));
		
		
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
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
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