<?php
const ESTADO_CREADO='10';
const ESTADO_CERRADO='20';
const ESTADO_ANULADO='30';
const ESTADO_CONFIRMADO='40';
const TIPO_DE_FLUJO_A_RENDIR='102';


class CajachicaController extends ControladorBase
{

	public function __construct() {
		parent::__construct($id='cajachica',Null);
		$this->documento='370';
		$this->modelopadre='Cajachica';
		$this->modeloshijos=array();
		$this->documentohijo='200';
		$this->ConfigArreglos();
		$this->campoestado='codestado';

	}
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
				'actions'=>array('create','borraitems','borraritemhijo','aprobaritem','update','creadetalle','actualizadetalle'),
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
	public function actionActualizadetalle($id)
	{
		$model=Dcajachica::model()->findByPk($id);
		if(is_null($model))
			throw new CHttpException(500,'No existe este detalle con este ID');
		if(isset($_POST['Dcajachica']))
		{
			$model->attributes=$_POST['Dcajachica'];
			if($model->save())
				if (!empty($_GET['asDialog']))
				{
					//Close the dialog, reset the iframe and update the grid
					echo CHtml::script("window.parent.$('#cru-dialogdetalle').dialog('close');
													                    window.parent.$('#cru-detalle').attr('src','');
																		window.parent.$.fn.yiiGridView.update('detalle-grid');
																		");
					Yii::app()->end();
				}
		}			// if (!empty($_GET['asDialog']))
		$this->layout = '//layouts/iframe';
		$this->render('_form_detalle',array(
			'model'=>$model, 'idcabeza'=>$model->hidcaja
		));



	}

	public function actionCierracaja()
	
	{
			$model=$this->loadModel($_POST['Cajachica']['id']);
		if(is_null($model))
		  {
		  echo "No se encontro el registro";
		  } else {
		     if($model->hijospendientes > 0 )		{
		  		echo "No se puede cerrar, faltan confirmar los items";
		  		} else {
		  		$model->setScenario('cambiaestado');
		  		$model->codestado='20';
		  		if($model->save())
		  		echo " Se cambio el estado";
		  		 }
		  		
		  }
					
					
	}



	public function actionBorraritemhijo()
	{
		if(!isset($_GET['ajax'])) {
			$identidad = $_GET[ 'id' ];
		$this->borraitemhijox($identidad);

		}

			}











	
	public function actionAprobaritem()
	{
		if(!isset($_GET['ajax'])) {
			$identidad = $_GET[ 'id' ];
			$modelo = Dcajachica::model ()->findByPk ( $identidad );
			if ( is_null ( $modelo ) )
				throw new CHttpException( 500 , 'No existe esta solicitud con este ID    ' . $_GET[ 'id' ] . '    ' );

			//primero si le corresponde
			if ( $modelo->isTratable () ) {
				if ( ! $modelo->tieneHijospendientes () ) {

					if($modelo->codestado = ESTADO_CREADO)
					{
						$modelo->delete ();
						ECHO "Se borro el item ";
					}else{
						ECHO "Este item no tiene el Status adecuado para borralo";
					}


				} else {
					echo "  Este cargo  tiene registro pendientes  y no se puede anular " ;
				}

			} else {
				echo "El status no es le adecuado, o está intentando actualizar un registro que no es de su autoridad";
			}

		}

else {

}
	 
	 
	 

	}

 public function borraitemhijox($id){
	 $modelo = Dcajachica::model ()->findByPk ( $id );
	 if ( is_null ( $modelo ) )
		 throw new CHttpException( 500 , 'No existe esta solicitud con este ID    ' . $_GET[ 'id' ] . '    ' );

	 //primero si le corresponde
	 if ( $modelo->isTratable () ) {
		 if ( ! $modelo->tieneHijospendientes () ) {

			 $modelo->codestado <> ESTADO_CONFIRMADO;
			 $modelo->delete();
			 ECHO "Se anulo el item ";

		 } else {
			 echo "  Este cargo  tiene registro pendientes " ;
		 }

	 } else {
		 echo "El status no es le adecuado, o está intentando actualizar un registro que no es de su autoridad";
	 }
 }


	public function actionBorraitems()
	{
         $cadeni="";
		$autoIdAll = $_POST['cajita'];
		 foreach($autoIdAll as $autoId)
			{

				$cadeni.=$this->borraitemhijox($autoId);

			}

         echo $cadeni;

	}





	public function actionCreadetalle($idcabeza)
	{
		$modelocabeza=Cajachica::model()->findByPk($_GET['idcabeza']);
		if(is_null($modelocabeza))
			throw new CHttpException(500,'No existe esta solicitud con este ID    '.$_GET['idcabeza'].'    ');
			$model=new Dcajachica;
			$model->valorespordefecto($this->documento);
		$model->{$this->campoestado}=ESTADO_CREADO;
		$model->coddocu=$this->documentohijo;
			// Uncomment the following line if AJAX validation is needed
			//$this->performAjaxValidation($model);

			if(isset($_POST['Dcajachica']))
			{
				$model->attributes=$_POST['Dcajachica'];
				if($model->save())
					if (!empty($_GET['asDialog']))
					{
						//Close the dialog, reset the iframe and update the grid
						echo CHtml::script("window.parent.$('#cru-dialog3').dialog('close');
													                    window.parent.$('#cru-frame3').attr('src','');
																		window.parent.$.fn.yiiGridView.update('detalle-grid');
																		");
						Yii::app()->end();
					}
			}			// if (!empty($_GET['asDialog']))
			$this->layout = '//layouts/iframe';
			$this->render('_form_detalle',array(
				'model'=>$model, 'idcabeza'=>$idcabeza
			));



	}







	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		///Verificamos que este bloqueado por el usuario
		if(MiFactoria::estasensesion($id,$this->documento)){
			$this->terminabloqueo($id);
			//$this->limpiatemporaldetalle();

		}


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
		//VERIFICAR SI S EPUEDE APERTIRAR LA CAJA
		//NO SE PUEDE APERTURAR SI HAY UNA CAJA ANTERIRO CON LA MISMA SERIE Y EL MISMO ID= HIDFONDO QUE FALTA CERRRAR






		$model=new $this->modelopadre;
		$model->valorespordefecto($this->documento);
		$model->iduser=Yii::app()->user->id;
		if(isset($_POST[$this->modelopadre]))
		{
			$model->attributes=$_POST[$this->modelopadre];
			$model->codestado='10';
			if($model->save()){
				$this->redirect(array('update','id'=>$model->id));

			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

private function buscasaldoanterior ($id){



}




	public function actionUpdate($id)
	{
		$model=MiFactoria::CargaModelo($this->modelopadre,$id);
		if($this->itsFirsTime($id))
		{
			if($this->getUsersWorkingNow($id))
			{ //si esta ocupado
				Yii::app()->user->setFlash('error', "El documento esta siendo modificado por otro usuario ");
				$this->redirect(array('view','id'=>$model->id));
			} else { // Si no lo esta renderizar sin mas
				$this->setBloqueo($id) ; 	///bloquea
				$this->render('update',array('model'=>$model));
				yii::app()->end();
			}

		} else {
			if($this->isRefreshCGridView($id))
			{ //si esta refresh de grilla
				$this->render('update',array('model'=>$model));
				yii::app()->end();
			} else { // Si no lo es  tenemos que analizar los dos casos que quedan
				if($this->IsRefreshUrlWithoutSubmit($id))
				{ ///Solo refreso la pagina
					Yii::app()->user->setFlash('notice', "No has confirmado los datos, solo haz refrescaod la pagina ");

					//echo "<br><br><br><br><br><br><br><br>salio eso";
					$this->render('update',array('model'=>$model));
					yii::app()->end();
				} else { 	 ///Ahora si recein se animo a hacer $_POST	, y confirmar los datos
					IF(isset($_POST[$this->modelopadre])) {
						$model->attributes=$_POST[$this->modelopadre];
						//if($model->hacambiado()) {
							if($model->save()){
								$this->terminabloqueo($id);
								Yii::app()->user->setFlash('success', "Se grabo el documento  ".$this->SQL);
								$this->redirect(array('view','id'=>$model->id));
							} else {
								Yii::app()->user->setFlash('error', "  NO s epudo granar e domcjuento ".$this->displaymensajes('error'));

								$this->render('update',array('model'=>$model));
								yii::app()->end();
								}
						//} else   {
							//Yii::app()->user->setFlash('notice', "  no has modificado nada  de la cabecera ");
							//$this->render('update',array('model'=>$model));
							//yii::app()->end();
						//}
					} else  { //En este caso quiere decir que la sesion/bloqueo anterior no se ha cerrado correactmente
						$this->terminabloqueo($id);
						$this->SetBloqueo($id);
						Yii::app()->user->setFlash('notice', "NO cerraste correctamente, Ya tenías una sesion abierta en este domcuento,");
						$this->render('update',array('model'=>$model));
						yii::app()->end();
					}
				}
			}
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
		$dataProvider=new CActiveDataProvider('Cajachica');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Cajachica('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cajachica']))
			$model->attributes=$_GET['Cajachica'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Cajachica the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Cajachica::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Cajachica $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='cajachica-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}