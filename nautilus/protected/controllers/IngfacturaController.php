<?php
const ESTADO_PREVIO='99';
const ESTADO_CREADO='10';
const ESTADO_ANULADO='30';
class IngfacturaController extends ControladorBase
{

	public function __construct() {
		parent::__construct($id='ingfactura',Null);
		$this->documento='280';
		$this->modelopadre='Ingfactura';
		$this->modeloshijos=array('Detingfactura'=>'Tempdetingfactura');
		$this->documentohijo='280';
		$this->campoestado='codestado';
		$this->ConfigArreglos();
		//$nuevo=new $this->modelopadre;
		//$this->campoenlace=$nuevo->getFieldLink($nuevo->relations(),$this->modelopadre,);

	}



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
				'actions'=>array('create','salir','crearingreso','confirmaringreso','update'),
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
		$model=new Ingfactura;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Ingfactura']))
		{
			$model->attributes=$_POST['Ingfactura'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Ingfactura']))
		{
			$model->attributes=$_POST['Ingfactura'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
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
		$dataProvider=new CActiveDataProvider('Ingfactura');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Ingfactura('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Ingfactura']))
			$model->attributes=$_GET['Ingfactura'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Ingfactura the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Ingfactura::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Ingfactura $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='ingfactura-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionCrearingreso()
	{
		$model=new $this->modelopadre;
		$model->codestado= ESTADO_PREVIO;
		$model->codocu=$this->documento;
		//$this->performAjaxValidation($model);

		$this->ClearBuffer($id=null);
		$model->iduser=Yii::app()->user->id;

		if(isset($_POST[$this->modelopadre]))
		{$model->attributes=$_POST[$this->modelopadre];

			if($model->save()){
				$this->redirect(array('confirmaringreso','id'=>$model->id));
			}
		}
		//echo "<br><br><br><br> al final   ".($model->isnewRecord)?"ES NUEVO ":"YA NO ES NUVEO";
		$this->render('update',array('model'=>$model));
	}

	public function actionConfirmaringreso($id)
	{
		$model=MiFactoria::CargaModelo($this->modelopadre,$id);
		$this->performAjaxValidation($model);
		if($this->itsFirsTime($id))
		{
			if($this->getUsersWorkingNow($id))
			{ //si esta ocupado
				$this->redirect(array('view','id'=>$model->id));
			} else { // Si no lo esta renderizar sin mas
				$this->setBloqueo($id) ; 	///bloquea
				$this->ClearBuffer($id); //Limpia temporal antes de levantar
				/*echo "si vino";
				yii::app()->end();*/
				if($model->codestado==ESTADO_PREVIO){
					MiFactoria::insertadetallesrecepfactura($model);
				}ELSE{
					$this->IniciaBuffer($id); //Levanta temporales
				}

				$this->render('_form',array('model'=>$model));
				yii::app()->end();
			}
		} else {
			if($this->isRefreshCGridView($id))
			{ //si esta refresh de grilla
				$this->render('_form',array('model'=>$model));
				yii::app()->end();
			} else { // Si no lo es  tenemos que analizar los dos casos que quedan
				if($this->IsRefreshUrlWithoutSubmit($id))
				{ ///Solo refreso la pagina
					Yii::app()->user->setFlash('notice', "No has confirmado los datos, solo haz refrescaod la pagina ");
					$this->render('_form',array('model'=>$model));
					yii::app()->end();
				} else { 	 ///Ahora si recein se animo a hacer $_POST	, y confirmar los datos
					IF(isset($_POST[$this->modelopadre])) {

						$model->attributes=$_POST[$this->modelopadre];
						//$model->cestadovale='20';
						if($model->save()){

							$this->ConfirmaBuffer($id); //Levanta temporales
							$transacc=$model->dbConnection->beginTransaction();
							$this->efectuamovimiento($model/*$id*/); //oJO SOLO DESPUES DE COFIRMAR BUFFER
							if(!$this->detectaerrores())
							{ $transacc->commit();
								Yii::app()->user->setFlash('success', "Se grabo el documento  ".$this->SQL);
								$this->ClearBuffer($id);
								$this->terminabloqueo($id);
								$this->redirect(array('update','id'=>$model->id));
							} else {//print_r(yii::app()->user->getFlashes());
								Yii::app()->user->setFlash('error', "Se ha presentado algunos inconvenientes ".$this->displaymensajes('error'));
								$transacc->rollback();
								//$this->borrakardexhijos($id);
								//$this->ClearBuffer($id);
								$this->terminabloqueo($id);

								$this->render('_form',array('model'=>$model));
								yii::app()->end();
							}
						} else {
							Yii::app()->user->setFlash('error', " No se pudo grabar el documento  ");
							//$transacc->rollback();
							$this->render('_form',array('model'=>$model));
							yii::app()->end();
							/*Yii::app()->end();
                            throw new CHttpException(500,'Hubo un error al momento de grabar la cabecera');*/
						}

					} else  { //En este caso quiere decir que la sesion/bloqueo anterior no se ha cerrado correactmente
						// Y es posble que haya entrado despues de 2 dias, una semana asi
						$this->terminabloqueo($id);
						$this->SetBloqueo($id);
						Yii::app()->user->setFlash('notice', "NO cerraste correctamente, Ya tenías una sesion abierta en este domcuento,");
						$this->render('_form',array('model'=>$model));
						yii::app()->end();

					}
				}
			}

		}

	}


	//hacer las cosas adicionales en las tabas relacionadas
public function efectuamovimiento($model/*$id*/){
	$crote=New CDBCriteria;
	$model->documento=$this->documento;
	$crote->addCondition("codcentro=:vcentro");
	$crote->params=array(":vcentro"=>$model->codcentro);
	$model->numerodoc=$model->Correlativo('numerodoc',$crote,null,8);
	//primero actualizar la OC para que salga efectuado
	//$registrocompra=Ocompra::findByNumero($model->numocompra);
	//$registrocompra->codestado=ESTADO_OC_FACTURADA_PARCIAL;




				}

public function actionsalir($id){
	$this->out($id);
	$this->redirect(array("admin"));
}
}
