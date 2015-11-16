<?php

class AuthobjetosController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array('accessControl',array('CrugeAccessControlFilter'));
	}

	public function accessRules()
	{
		Yii::app()->user->loginUrl = array("/cruge/ui/login");
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','updateauth','agregarvalores','agregarrangos','borrarangos'),
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
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		Authobjetosrango::model()->findByPk($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionagregarvalores($id,$idu)
	{
			$modelopadre=$this->loadModel($id);
		$usuario = Yii::app()->user->um->loadUserById($idu,true);
		/*var_dump($usuario);
		yii::app()->end();*/
		if(is_null($usuario))
			throw new CHttpException(500,'El userId '.$idu.' no existe.');

		if(isset($_POST['cajita']))		{
				//$model->attributes=$_POST['Tempdetgui'];
					$caja=$_POST['cajita'];
			   foreach($caja as $valor){
				   $modelk=Authobjetoslista::model()->find(" hidobjeto=:vobjeto AND iduser=:vuser  AND valorobjeto=:vvalor ",
					   array(":vobjeto"=>$modelopadre->id,":vuser"=>$_POST['iduser'],":vvalor"=>$valor));
				     if(is_null($modelk)){
						 $modelin= new Authobjetoslista('centros');
						 $modelin->hidobjeto=$modelopadre->id;
						 $modelin->iduser=$idu;
						 $modelin->valorobjeto=$valor;
						 $modelin->signo=-1;
						 $modelin->save();
					 }

			                   }


					//if($model->save())
					if (!empty($_GET['asDialog']))
					{
						//Close the dialog, reset the iframe and update the grid
						echo CHtml::script("window.parent.$('#cru-dialog3').dialog('close');
													                    window.parent.$('#cru-detalle3').attr('src','');
																		window.parent.$.fn.yiiGridView.update('detalle-grid1');
																		");
						Yii::app()->end();
					}
			}
			// if (!empty($_GET['asDialog']))
			$this->layout = '//layouts/iframe';
			$this->render('vw_centros',array());
	}




	public function actionagregarrangos($id,$idu)
	{
		$modelopadre=$this->loadModel($id);
		$usuario = Yii::app()->user->um->loadUserById($idu,true);
		/*var_dump($usuario);
		yii::app()->end();*/
		if(is_null($usuario))
			throw new CHttpException(500,'El userId '.$idu.' no existe.');

		$model=new Authobjetosrango('centros');
		if(isset($_POST['Authobjetosrango'])){
			$model->attributes=$_POST['Authobjetosrango'];
			$model->iduser=$idu;
			$model->hidobjeto=$modelopadre->id;
			$model->signo=1;
			$model->save();
			/*print_r($model->geterrors());
			yii::app()->end();*/
			if (!empty($_GET['asDialog']))
			{
				//Close the dialog, reset the iframe and update the grid
				echo CHtml::script("window.parent.$('#cru-dialog3').dialog('close');
													                    window.parent.$('#cru-detalle3').attr('src','');
																		window.parent.$.fn.yiiGridView.update('detalle-grid2');
																		");
				Yii::app()->end();
			}
		}
		// if (!empty($_GET['asDialog']))
		$this->layout = '//layouts/iframe';

		$this->render('vw_centros_rango',array('model'=>$model));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Authobjetos;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Authobjetos']))
		{
			$model->attributes=$_POST['Authobjetos'];
			if($model->save())
				$this->redirect(array('update','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}


	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Authobjetos']))
		{
			$model->attributes=$_POST['Authobjetos'];
			if($model->save())
				yii::app()->user->setFlash('success','Se ha modificado el registro');
				$this->redirect(array('update','id'=>$model->id));
		}

		$this->render('updatex',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdateAuth($id,$iduser)
	{
		$id=(int)$id;
		$iduser=(int)$iduser;
		$model=$this->loadModel($id);
		$usuario = Yii::app()->user->um->loadUserById($iduser,true);
		/*var_dump($usuario);
		yii::app()->end();*/
		if(is_null($usuario))
			throw new CHttpException(500,'El userId '.$userid.' no existe.');
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$this->render('update',array(
			'model'=>$model,'usuario'=>$usuario,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		Authobjetoslista::model()->findByPk($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}



	public function actionBorrarangos($id)
	{
		Authobjetosrango::model()->findByPk($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Authobjetos');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Authobjetos('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Authobjetos']))
			$model->attributes=$_GET['Authobjetos'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Authobjetos the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Authobjetos::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Authobjetos $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='authobjetos-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
