<?php

class NovedadesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $direcciones ; // array para gusrdar las ddirecciones de  los destinataris a enviar 

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
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin','arojas','jramirez'),
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
		$model=new Novedades;
		$model->advertencia="Coloque la criticidad de esta novedad con mucho cuidado, en el caso de que sea grave un correo sera enviado a las personas involucradas";

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
  
		if(isset($_POST['Novedades']))
		{
			$model->attributes=$_POST['Novedades'];
			if($model->save()) {
			  $model->refresh();
			          if(($model->criticidad =='A') OR ($model->criticidad =='B')) 
			         $this->enviacorreo(substr($model->descridetalle,0,35),$model->descridetalle,$model->idnovedad);
								if (!empty($_GET['asDialog']))
												{
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialog1').dialog('close');
													                    window.parent.$('#cru-frame1').attr('src','');
																		window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');
																		
																		");
														Yii::app()->end();
												}
				}
			   
			//	$this->redirect(array('view','id'=>$model->idnovedad));
		}
         
		
							if (!empty($_GET['asDialog'])and isset($_GET['idparte']) ) 
							//if (!empty($_GET['asDialog']) ) 
											{	
											 //ECHO "HOLA MANIT232O";
											$codigodelparte=$_GET['idparte'];
												//$this->render_partial('/clipro/_form_creardirecciones',array('model'=>$model,'codigoproveedor'=>$codigoproveedor,));
											} else {
											$codigodelparte=0;
											}
		   //----- begin new code --------------------
				if (!empty($_GET['asDialog']))
					$this->layout = '//layouts/iframe';
					
					
		$this->render('create',array(
			'model'=>$model,'codigodelparte'=>$codigodelparte,
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
		$model->advertencia="Coloque la criticidad de esta novedad con mucho cuidado, en el caso de que sea grave un correo sera enviado a las personas involucradas";


		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Novedades']))
		{
			$model->attributes=$_POST['Novedades'];
			if($model->save()) {
			            $model->refresh();
			            if(($model->criticidad =='A') OR ($model->criticidad =='B')) 
			             $this->enviacorreo(substr($model->descridetalle,0,35),$model->descridetalle,$model->idnovedad);
						 
									if (!empty($_GET['asDialog']))
												{
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialog').dialog('close');
													                    window.parent.$('#cru-frame').attr('src','');
																		window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');
																		");
														Yii::app()->end();
												}
			
			
										//$this->redirect(array('view','id'=>$model->idnovedad));
							}
				
		}
					if (!empty($_GET['asDialog']) ) 
							//if (!empty($_GET['asDialog']) ) 
											{	
											 //ECHO "HOLA MANIT232O";
											$codigodelparte=$_GET['idparte'];
												//$this->render_partial('/clipro/_form_creardirecciones',array('model'=>$model,'codigoproveedor'=>$codigoproveedor,));
											} else {
											$codigodelparte=0;
											}
		
		
		
		
		
			if (!empty($_GET['asDialog']))
					$this->layout = '//layouts/iframe';
		
		
				$this->render('update',array(
					'model'=>$model,'codigodelparte'=>$codigodelparte,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$aper=$this->loadModel($id);
		$reportepes=ReportePesca::model()->findByPk($aper->hidparte);
		$reportepes->evento=0;		
		$aper->delete();
        $reporetepes->save();	
		//$this->loadModel($id)->
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Novedades');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Novedades('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Novedades']))
			$model->attributes=$_GET['Novedades'];

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
		$model=Novedades::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'El enlace o direccion solicitado no existe');
		return $model;
	}
	
	
	public function codigobarco() {
				if (isset(Yii::app()->user->um)) { //si tiene cruge 
				  return Yii::app()->user->getField('codep');
					}
						 else { //si tienen el modeulo user 
							return Yii::app()->getModule('user')->user()->profile->codep;
						} 
	 }
	 
	
	
	
	
	public function enviacorreo($subject,$message,$id)
			{
			$modeloparte=Partes::model()->find('id=:hidparte',array(':hidparte'=>$id));
			//echo "el tipo es ".gettype($id). "--".$id;
			//$subject="Novedad   ".$modeloparte->embarcaciones->nomep."   ".
			$this->direcciones='jramirez@exalmar.com.pe,arojas@exalmar.com.pe' ;
		   // Contactos::model()->find('c_hcod=:c_hcod', array(':c_hcod'=>$model->codpro))
    	$adminEmail = Yii::app()->user->getField('apaterno')." ".Yii::app()->user->getField('amaterno')." ".Yii::app()->user->getField('nombres')." <".Yii::app()->user->email.">" ;
	    $headers = "MIME-Version: 1.0\r\nFrom: $adminEmail\r\nReply-To: $adminEmail\r\nContent-Type: text/html; charset=utf-8";
	     $message = "Este es un mensaje  de novedad :\n.".$message;
		$message = wordwrap($message, 70);
	    $message = str_replace("\n.", "\n..", $message);
	    return mail($this->direcciones,'=?UTF-8?B?'.base64_encode($subject).'?=',$message,$headers);
	         
	
			}
	
	

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='novedades-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
