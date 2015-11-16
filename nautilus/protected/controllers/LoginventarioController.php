<?php

class LoginventarioController extends Controller
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
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('index','view','update','actualiza','actualizaprov'),
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Loginventario;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Loginventario']))
		{
			$model->attributes=$_POST['Loginventario'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->idlog));
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
	public function actionUpdate()
	{
	
	 // 
	 // echo "some sort of response";
		$command = Yii::app()->db->createCommand("select fn_aceptaloginventario(".$_POST['vidinventario'].",".$_POST['vidlog'].",'".$_POST['vlugar']."')"); 
		$command->execute();
		//echo jsonencode("---".$_POST['vidinventario']."---".$_POST['vidlog']."----".$_POST['vlugar']."----") ;
		echo $_POST['vlugar'];
		Yii::app()->end();
	  
	  // $this->render_partial("vw_hecho");
	   //echo "carajo";
	}

	
	
	public function actionActualizaprov()
	{
	   // if (isset($_POST['idlog'])) {
						//$command = Yii::app()->db->createCommand("update loginventario set creadopor='huevo'  where idlog=".$_POST["genio"]." "); 
			//	$caray=$_POST['genio'];
			//	$idlog=$_POST['idlog']+0;
				//$modelito=VwLoginventari::model()->findByAttributes(array('idlog'=>$idlog));
				$command = Yii::app()->db->createCommand("select fn_aceptaloginventario(".$_POST['hidinventario'].",".$_POST['idlog'].",'".$_POST['codpro']."')"); 
				//echo "select fn_aceptaloginventario(".$_POST['hidinventario'].",".$_POST['idlog'].",'".$_POST['codpro']."')";
				//if (!is_null($modelito->codpro)) {
				//echo 
				
				//$command = Yii::app()->db->createCommand("update loginventario set creadopor='".$modelito->codpro."' "); 
				//$command = Yii::app()->db->createCommand("update loginventario set creadopor='carajo'  where idlog=".$_POST["idlog"]." "); 				
				//}
				//  else{
				 // $command = Yii::app()->db->createCommand("update loginventario set creadopor='kokum'  where idlog=".$_POST["genio"]." "); 				
				
				 // } 
				$command->execute();
		//} else {
		        //$command = Yii::app()->db->createCommand("update loginventario set creadopor='mmm' "); 
		//		//$command->execute();
		 //  }
		     //echo "---".$_POST['idlog']."-".$_POST['hidinventario']."-".$_POST['codpro']."----";
		// return true;
						Yii::app()->end();
	}
	
	public function actionActualiza()
	{
	
		$autoIdAll = $_POST['cajita'];
      if(count($autoIdAll)>0)
        {
           foreach($autoIdAll as $autoId)
           {
               // $cadena=
				$modelito=$this->loadModel($autoId);
				$command = Yii::app()->db->createCommand("select fn_aceptaloginventario(".$modelito->hidinventario.",".$modelito->idlog.",'".$_POST["lugarcitos"]."')"); 
				 $command->execute();
            }
		    
			Yii::app()->end();
	    
	}
	}
	
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
       $this->mamichulao();
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Loginventario');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Loginventario('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Loginventario']))
			$model->attributes=$_GET['Loginventario'];

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
		$model=Loginventario::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'El enlace o direccion solicitado no existe');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='loginventario-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
