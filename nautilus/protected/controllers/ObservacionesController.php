<?php

class ObservacionesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $direcciones;

	/**
	 * @return array action filters
	 */
public function filters()
	{
		return array('accessControl',array('CrugeAccessControlFilter'));
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		 Yii::app()->user->loginUrl = array("/cruge/ui/login");
		
		
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','admin'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('cambiaestado','create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
				'users'=>array('*'),
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
	public function actionCreate($idinventario)
	{
		$model=new Observaciones;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Observaciones']))
		{
			$model->attributes=$_POST['Observaciones'];
			//$model->usuario=Yii::app()->getModule('user')->user()->username;
			$modelitoactivo=Inventario::model()->findByPk($model->hidinventario);
			$model->codestado='10';
			if($model->save())
			  // echo "salio";
			  $this->enviamail($modelitoactivo,$model);
			    $model->refresh();
				
								if (!empty($_GET['asDialog']))
												{
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialog').dialog('close');
													                    window.parent.$('#cru-frame').attr('src','');
																		window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');
																	
																		");
														Yii::app()->end();
												}
				
				
				$this->render('Confirma',array('id'=>$model->id));
				Yii::app()->end();
		}
		
		
		
		$modeloinventario=Inventario::model()->findByPk($idinventario);
		$fot=new Fotos($modeloinventario->codigosap,Yii::app()->params['rutafotosinventario'],'.JPG' ) ;		
		$misfotos=$fot->devuelveFotos();
		if (!empty($_GET['asDialog']))
					$this->layout = '//layouts/iframe';
		$this->render('create',array(
			'model'=>$model,'modeloinventario'=>$modeloinventario,'misfotos'=>$misfotos,'ruta'=>Yii::app()->params['rutafotosinventario_'],'fot'=>$fot,
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

		if(isset($_POST['Observaciones']))
		{
			$model->attributes=$_POST['Observaciones'];
			$model->usuario=Yii::app()->user->name;
			
			if($model->save())
			     
				 
				 
				 
				$this->redirect(array('view','id'=>$model->id));
		}

		if (trim($model->usuario) == trim(Yii::app()->user->name)) 
				{
				 $modeloinventario=Inventario::model()->findByPk($model->hidinventario);
				 $fot=new Fotos($modeloinventario->codigosap,Yii::app()->params['rutafotosinventario'],'.JPG' ) ;		
				$misfotos=$fot->devuelveFotos();		
					$this->render('update',array(
					'model'=>$model,'modeloinventario'=>$modeloinventario,'misfotos'=>$misfotos,'ruta'=>Yii::app()->params['rutafotosinventario_'],'fot'=>$fot,
					));
		
				} else {
				$this->render('denegado',array(
					'model'=>$model,
				));	
				
				}
	}
	
	
	
	
	public function actionCambiaestado()
	{
		$identidad=$_GET['colo'];		
		$model=$this->loadModel($identidad);
		$model->codestado='02'; //CERRADO	
			if (trim($model->usuario)==trim(Yii::app()->user->name))		
				{
					$model->save();
				  echo "Se Cerro la observacion ";														
			 } 
			 else 
			 {
					echo "No Puede cerrar esta observacion porque fue creada por el usuario :".$model->usuario;										
			  }
						
			//Yii::app()->end;	
										
			}	

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
				{
								if (trim($model->usuario)==trim(Yii::app()->getModule('user')->user()->username))		
										{
		
											$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
												if(!isset($_GET['ajax']))
												$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
										}
											ELSE
	
												{ 
														$this->render('denegado',array(
													'model'=>$model,
				));	
				
				}
				
				}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Observaciones');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new VwObservaciones('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['VwObservaciones']))
			$model->attributes=$_GET['VwObservaciones'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	
	public function enviamail($model,$model1)
	
			{
			$subject=$model1->descri." ".$model->codigoaf." ".$model->descripcion;
			//$modeloparte=Inventarioartes::model()->find('id=:hidparte',array(':hidparte'=>$id));
			//echo "el tipo es ".gettype($id). "--".$id;
			//$subject="Novedad   ".$modeloparte->embarcaciones->nomep."   ".
			//$this->direcciones='mcampana@exalmar.com.pe,rnoriega@exalmar.com.pe,jramirez@exalmar.com.pe,ecastaneda@exalmar.com.pe,aruiz@exalmar.com.pe,jdominguez@exalmar.com.pe,jcarrasco@exalmar.com.pe,jtoledo@exalmar.com.pe,focana@exalmar.com.pe,gfillies@exalmar.com.pe,fangulo@exalmar.com.pe,tvictorio@exalmar.com.pe' ;
		 //$this->direcciones='jramirez@exalmar.com.pe';
		  // Contactos::model()->find('c_hcod=:c_hcod', array(':c_hcod'=>$model->codpro))
    	
		$this->direcciones='jramirez@exalmar.com.pe,ecastaneda@exalmar.com.pe,focana@exalmar.com.pe,jtoledo@exalmar.com.pe,mcampana@exalmar.com.pe,jvenegas@exalmar.com.pe,jaguilar@exalmar.com.pe';
		// $this->direcciones='jramirez@exalmar.com.pe';//,jtoledo@exalmar.com.pe,ecastaneda@exalmar.com.pe';
		$adminEmail =Yii::app()->user->getField('nombres')." ".Yii::app()->user->getField('apaterno')." ".Yii::app()->user->getField('amaterno')." <".Yii::app()->user->email.">" ;
	    $headers = "MIME-Version: 1.0\r\nFrom: $adminEmail\r\nReply-To: $adminEmail\r\nContent-Type: text/html; charset=utf-8";
	    
			$message="<head>";
			$message=$message."<style type='text/css'> ";
			$message=$message."table.gridtable {font-family: verdana,arial,sans-serif;font-size:11px;color:#333333;padding: 18px;border-width: 1px;width :600border-color: #ccddee;border-collapse: collapse;background-color: #dedede;}";
			$message=$message."table.gridtable th {border-width: 1px;padding: 8px;border-style: solid;border-color: #666666;background-color: #dedede;}";
			$message=$message."table.gridtable td {border-width: 1px;padding: 8px;border-style: solid;border-color: #666666;background-color: #ccddff;}";
			$message=$message."</style></head>";
		$message = $message."Correo automatico : ";
        $message = $message."Se ha hecho una observacion  <b> ".$model->codigoaf." </b> al activo : <br><br>";
		  $message =$message."<table  class='gridtable'  ><tr><td>  DESCRIPCION : </td><td>".$model->descripcion."</td></tr><br>";
		 $message =$message."<tr><td>Observacion :</td><td>".$model1->mobs."</td></tr>";
		 $message =$message."<tr><td> MARCA :</td><td>".$model->marca."</td></tr><br>";
		  $message =$message."<tr><td>MODELO :</td><td>".$model->modelo."</td></tr><br>";
		  $message =$message."<tr><td>SERIE :</td><td>".$model->serie."</td></tr><br>";
		$modi=Embarcaciones::model()->findByPk(trim($model->codep));
			$meny=(is_null($modi->nomep))?"   ":$modi->nomep;
			$message =$message."<tr><td>REFERENCIA :</td><td>".$meny."</td></tr><br>";
			$message =$message."<tr><td>Foto :</td><td><img src='http://".Yii::app()->params['ipservidor'].Yii::app()->params['rutafotosinventario_'].trim($model->codigosap).".jpg'></td></tr><br><br></table>";
			
			$message =$message." <br>Si no desea recibir este correo, notifique al remitente para eliminarlo de la lista";
		   // echo "sietieotoe".$modi->nomep;
		$message = wordwrap($message, 70);
	    //$message = str_replace("\n.", "\n..", $message);
	    return mail($this->direcciones,'=?UTF-8?B?'.base64_encode($subject).'?=',$message,$headers);
	         
	
			}
	
	
	
	
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Observaciones::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='observaciones-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
