<?php

class ContactosController extends Controller
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
				'actions'=>array('create','contactosporprove','borradetalle','modificadetalle','creaadicional','update'),
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

	public function actionContactosporprove(){
		$criteria = new CDbCriteria();
		$criteria->addCondition("c_hcod=:proved");
		$valor=$_POST['codigoprov'];
		//echo $valor;
		//yii::app()->end();
		$criteria->params=array(":proved"=>$valor);
		$data=CHtml::listData(	Contactos::model()->findAll($criteria),
			//$data=CHtml::listData(	Direcciones::model()->findAll(),
			"id",
			"c_nombre"

		);
		echo CHtml::tag('option', array('value'=>null),CHtml::encode('Escoja un contacto'),true);
		foreach($data as $value=>$name) {
			echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
		}

	}



	public function actioncreaadicional($idcabeza){

				$model=new Contactosadicio();
		        $model->hidcontacto=$idcabeza;
				if(isset($_POST['Contactosadicio']))		{
					$model->attributes=$_POST['Contactosadicio'];
					$model->save();
							//Close the dialog, reset the iframe and update the grid
							echo CHtml::script("window.parent.$('#cru-dialog').dialog('close');
													                    window.parent.$('#cru-detalle').attr('src','');
																		window.parent.$.fn.yiiGridView.update('detalle-grid');
																		");
							Yii::app()->end();

				}
				// if (!empty($_GET['asDialog']))
				$this->layout = '//layouts/iframe';
				$this->render('_form_detalle',array(
					'model'=>$model, 'idcabeza'=>$idcabeza
				));

			}



	public function actionmodificadetalle($id){
		$model=Contactosadicio::model()->findByPk($id);
		//echo "salio";
		//$model->hidcontacto=$idcabeza;
		if(isset($_POST['Contactosadicio']))		{
			$model->attributes=$_POST['Contactosadicio'];
			$model->save();
			//Close the dialog, reset the iframe and update the grid
			echo CHtml::script("window.parent.$('#cru-dialog').dialog('close');
													                    window.parent.$('#cru-detalle').attr('src','');
																		window.parent.$.fn.yiiGridView.update('detalle-grid');
																		");
			Yii::app()->end();

		}
		//if (!empty($_GET['asDialog']))
		$this->layout = '//layouts/iframe';
		$this->render('_form_detalle',array(
			'model'=>$model,
		));

	}

	public function actionborradetalle($id){
		$model=Contactosadicio::model()->findByPk($id);
		//echo "salio";
		$model->delete();
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Contactos;
		$model->setScenario("creasolo");
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Contactos']))
		{
			$model->attributes=$_POST['Contactos'];
			
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

		if(isset($_POST['Contactos']))
		{
			$model->attributes=$_POST['Contactos'];
			if($model->save())
						           if (!empty($_GET['asDialog']))
												{
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialog2').dialog('close');window.parent.$('#cru-frame2').attr('src','');window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');");
														Yii::app()->end();
												}
			  $this->redirect(array('view','id'=>$model->id));
			
				
		}
			
		 //----- begin new code --------------------
				if (!empty($_GET['asDialog'])){
					$this->layout = '//layouts/iframe';
					$codigoproveedor=$_GET['codpro'];
					} else {$codigoproveedor=$model->c_hcod;}
    //----- end new code --------------------
		$this->render('_form',array(
			'model'=>$model,'codpro'=>$codigoproveedor,
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
		$dataProvider=new CActiveDataProvider('Contactos');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Contactos('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Contactos']))
			$model->attributes=$_GET['Contactos'];

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
		$model=Contactos::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='contactos-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
