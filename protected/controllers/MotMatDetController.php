<?php

class MotMatDetController extends Controller
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','delete','aprobar'),
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
		$model=new MotMatDet;
		
		
		
		  ///`PARA CONTROLAR LOS ITEMS GENRADOS 
			if (!isset(Yii::app()->session['numeroitem'])) 
		       Yii::app()->session['numeroitem'] = 1;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MotMatDet']))
		{
			$model->attributes=$_POST['MotMatDet'];
			// Yii::app()->session['numeroitem'] = (int)$model->item+1;
			if($model->save())
				{
				    Yii::app()->session['numeroitem']=Yii::app()->session['numeroitem']+1;
				
						if (!empty($_GET['asDialog']))
												{
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialogdetalle').dialog('close');
													                    window.parent.$('#cru-detalle').attr('src','');
																		window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');
																		");
														Yii::app()->end();
												}
				}
		}

		
		if (!empty($_GET['asDialog'])and isset($_GET['naleatorio']) )  
							//if (!empty($_GET['asDialog']) ) 
							$this->layout = '//layouts/iframe';
							//$this->layout = ''.Resuelveruta::ArreglaRuta(Yii::app()->getTheme()->baseUrl.'/views/layouts/iframe');			
		     // echo $this->layout;
					
					
		$this->render('create',array(
			'model'=>$model,'naleatorio'=>$_GET['naleatorio'],
		));
		
		
	}

	
	
	public function actionRelaciona()
	{
		$ordencampo=$_GET['ordencampo'];
			$campito=$_GET['campo'];
			$vvalore=$_POST['Inventario'][$campito];
			$relaciones=$_GET['relaciones'];			
			 echo  Fotos::buscavalor($campito,$vvalore,$ordencampo,$relaciones);
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
		
		if(isset($_POST['MotMatDet']))
		{
			$model->attributes=$_POST['MotMatDet'];
			if($model->save()) {
			            $model->refresh();
			            //if(($model->criticidad =='A') OR ($model->criticidad =='B')) 
			            // $this->enviacorreo(substr($model->descridetalle,0,35),$model->descridetalle,$model->idnovedad);
						 
									if (!empty($_GET['asDialog']))
												{
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialogdetalle').dialog('close');
													                    window.parent.$('#cru-detalle').attr('src','');
																		window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');
																		");
														Yii::app()->end();
												}
			
			
										//$this->redirect(array('view','id'=>$model->idnovedad));
							}
				
		}
				/*	if (!empty($_GET['asDialog']) ) 
							//if (!empty($_GET['asDialog']) ) 
											{	
											 //ECHO "HOLA MANIT232O";
											$codigodelparte=$_GET['idparte'];
												//$this->render_partial('/clipro/_form_creardirecciones',array('model'=>$model,'codigoproveedor'=>$codigoproveedor,));
											} else {
											$codigodelparte=0;
											}*/
		
		
		
		
		
			if (!empty($_GET['asDialog']))
					$this->layout = '//layouts/iframe';
		
		
				$this->render('update',array(
					'model'=>$model,
					'naleatorio'=>$_GET['naleatorio'],
								));
		
		
		/*if(isset($_POST['MotMatDet']))
		{
			$model->attributes=$_POST['MotMatDet'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
			//'idcabecera'=>$model->,
		));*/
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		//$this->loadModel($id)->delete();
		$model= $this->loadModel($id);
         $model->estado='03';
		  $model->save();
		if (!empty($_GET['asDialog']))
												{
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialogdetalle').dialog('close');
													                    window.parent.$('#cru-detalle').attr('src','');
																		window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');
																		");
														Yii::app()->end();
												}
			
		
		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		//if(!isset($_GET['ajax']))
			//$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	
	
	
	public function actionAprobar($id)
	{
		//$this->loadModel($id)->delete();
		$model= $this->loadModel($id);
         $model->estado='02';
		  $model->save();
		   return true; 
		/* if (!empty($_GET['asDialog']))
												{
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialogdetalle').dialog('close');
													                    window.parent.$('#cru-detalle').attr('src','');
																		window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');
																		");
														Yii::app()->end();
												}*/
			
		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		//if(!isset($_GET['ajax']))
			//$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	
	
	
	
	
	
	
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('MotMatDet');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new MotMatDet('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MotMatDet']))
			$model->attributes=$_GET['MotMatDet'];

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
		$model=MotMatDet::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='mot-mat-det-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
