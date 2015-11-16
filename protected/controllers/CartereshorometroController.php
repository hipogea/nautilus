<?php

class CartereshorometroController extends Controller
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
	

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)	{
	
	// if ($this->verifica_acceso($id)) {
		$model=$this->loadModel($id);
		/********
		Estos atributos son para almacenar temporalmente
		los antiguos valores del horomtro y la fecha del ultimo
		cambio	
		**********/
		$model->setAttribute('vfulectura',$model->fulectura);
        $model->setAttribute('vhorometro',$model->horometro);			
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
				if(isset($_POST['Cartereshorometro']))
							{
								$model->attributes=$_POST['Cartereshorometro'];
													// if($model->checkhorometroparteesmenor() )  //si la fecha de cambio es mayor que cualquier lectira del parte 
													   // {
															//actualizar  la lectua del horometro tambien
															$model->setAttribute('horometro',$model->horometro);
															$model->setAttribute('fulectura',$model->fulectura);
														//}
								
											if($model->save()) {
													
												$this->redirect(array("partes/index"));
											
											}
							}

		/*Luego con estos valores  nos vamos a renderizar la vista apra poder pintar los valores y 
		ayudar al usuario para
		*/
		$fulecturaant=$model->vfulectura;
		$horometroant=$model->vhorometro;
		$this->render('update',array(
			'model'=>$model,'fulecturaant'=>$fulecturaant,'horometroant'=>$horometroant,
		));
	//  } else {
	  //   throw new CHttpException(404,'Estas intentado acceder a un equipo que no es el tuyo');
	 // }
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
		$dataProvider=new CActiveDataProvider('Carterescambio');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Carterescambio('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Carterescambio']))
			$model->attributes=$_GET['Carterescambio'];

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
		$model=Cartereshorometro::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'No se encontro el equipo.');
		return $model;
	}

	
	
	
	
	///ESTA FUNCION SIRVE PARA VALIDAR QUE CADA USUARIO PUEDA MODIFICAR SOLO LOS 
	///DATOS DE SU EMBARCACION EJEMPLO UN MOTORISTA DE LA EP CAMENCITA NO PUEDE 
	///MODIFAR DATOS DE LA EP RODAS ASI.
	
	private function verifica_acceso($id) {
	 $modelocarte= Vwaceites::model()->findByAttributes(array('id'=> $id));
	   if (!is_null($modelocarte)) {
	        //verificando que el motorista sewa el propietario de etos objetos
			 //echo " est ee s la voz  ".@gettype(Yii::app()->modules['cruge']);
			if ( is_null(@gettype(Yii::app()->modules['cruge'])))  { ///si esta instaldo CRUGE 
			         if( Yii::app()->user->getField('codep')==$modelocarte->codep) 
					 {return true;} else {return false;};
			} else { //SI NOLO ESTA VALIDAMOS CON EL COMPENTNE "USER"
			    if( Yii::app()->getModule('user')->user()->profile->codep ==$modelocarte->codep) 
				  {return true;} else {return false;};
			}
			
	   }else {
	     throw new CHttpException(404,'El valor pasado como parametro no es el correcto.');
	   }
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='carterescambio-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
