<?php

class ArchivadorController extends Controller
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
				'actions'=>array('index','view','admin'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','admin','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','update'),
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
		$model=new Archivador;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Archivador']))
		{
			$model->attributes=$_POST['Archivador'];
			//ECHO "la magen ".$_POST['Archivador']['archivo']."gsdghsdshdshdhsd  ";
			 $model->archivo=CUploadedFile::getInstance($model,'archivo');
		      /*   $mensaje="";
				 $mensaje2="";
				if (!(strtoupper($model->imagen->getExtensionName())=='JPG' or strtoupper($model->imagen->getExtensionName()=='JPEG')))
					$mensaje="El archivo no es una imagen valida  ".$model->imagen->getExtensionName();
			    $tamanomaximo=300;
				if ($model->imagen->getSize() > 1024*$tamanomaximo)
					$mensaje2="El archivo  es muy pesado :".(ROUND($model->imagen->getSize()/1024,2))." suba imagenes menores a ".$tamanomaximo." KB ";
				
				if (trim($mensaje.$mensaje2==""))  
				{
				  
					$fot=new Fotos($model->codigosap,Yii::app()->params['rutafotosinventario'],'.JPG' ) ;		
					$fotonueva=$fot->siguiente_numero();
					$model->imagen->saveAs($fot->rutadearchivos.$fotonueva);
					$this->redirect(array('detalle','id'=>$id));
				}
				  
				else 
				{
				   $this->render('vw_error_foto',array('mensaje'=>$mensaje,'mensaje2'=>$mensaje2));
				   
				  } */
			if (null==$model->archivo){
			  echo "es nulo";
			  Yii::app()->end();
			  
			  }
			  
		 if ( trim($model->verifica())=="" ) {
				if( ($model->save())  ) 
					{
					
					$rutita=Resuelveruta::ArreglaRuta(Yii::app()->params['rutadescargas'].$model->nombre.'.'.$model->archivo->getExtensionName());
									
					if ( $model->archivo->saveAs(Yii::getPathOfAlias('webroot').Yii::app()->params['rutadescargas'].$model->nombre.'.'.$model->archivo->getExtensionName()))
						{
									//ECHO Resuelveruta::ArreglaRuta(Yii::app()->params['rutadescargas'].$model->nombre.'.'.$model->archivo->getExtensionName());
									$this->redirect(array('admin'));
						} else {
									
									echo Yii::app()->params['rutadescargas'].$model->nombre.'.'.$model->archivo->getExtensionName();
									/*$this->render('error',array(
										'model'=>$model,'mensaje'=>"No se pudo guardar el archivo en el servidor verifique",
										));*/
								}
				
					} else {
								$this->render('error',array(
							'model'=>$model,'mensaje'=>$model->verifica(),
								));
				
						}
			} else {
			     	$this->render('error',array(
							'model'=>$model,'mensaje'=>$model->verifica(),
								));
			}
		}
		else {
		$this->render('create',array(
			'model'=>$model,
		));
		}
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
  if(trim(Yii::app()->user->name)==trim($model->autor)) {
		if(isset($_POST['Archivador']))
		{
			$model->attributes=$_POST['Archivador'];
			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	} else {
	throw new CHttpException(404,'Ha intentado actualizar una descarga que no es suya, comuniquese con el autor.');
	
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

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Archivador');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Archivador('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Archivador']))
			$model->attributes=$_GET['Archivador'];
			
			$ruti=Yii::app()->params['rutadescargas'];
		$this->render('admin',array(
			'model'=>$model,'ruti'=>$ruti,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Archivador::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='archivador-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	
	public function actionSubearchivo($id)
    {
        $model=new Archivador;
		//ECHO "la magen ".$_POST['image'];
        if(isset($_POST['Archivador']))
        {		  
            $model->attributes=$_POST['Archivador'];
            $model->imagen=CUploadedFile::getInstance($model,'imagen');
		         $mensaje="";
				 $mensaje2="";
				if (!(strtoupper($model->imagen->getExtensionName())=='JPG' or strtoupper($model->imagen->getExtensionName()=='JPEG')))
					$mensaje="El archivo no es una imagen valida  ".$model->imagen->getExtensionName();
			    $tamanomaximo=3000;
				if ($model->imagen->getSize() > 1024*$tamanomaximo)
					$mensaje2="El archivo  es muy pesado :".(ROUND($model->imagen->getSize()/1024,2))." suba imagenes menores a ".$tamanomaximo." KB ";
				
				if (trim($mensaje.$mensaje2==""))  
				{
				  
					$fot=new Fotos($model->codigosap,Yii::app()->params['rutafotosinventario'],'.JPG' ) ;		
					$fotonueva=$fot->siguiente_numero();
					$model->imagen->saveAs($fot->rutadearchivos.$fotonueva);
					$this->redirect(array('detalle','id'=>$id));
				}
				  
				else 
				{
				   $this->render('vw_error_foto',array('mensaje'=>$mensaje,'mensaje2'=>$mensaje2));
				   Yii::app()->end();
				  }
        }
		$model=$this->loadModel($id);
        $this->render('vw_subir_archivo', array('model'=>$model,'id'=>$id));
    }
	
	
	
	
	
}
