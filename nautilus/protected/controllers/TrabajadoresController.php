<?php

class TrabajadoresController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */

		public function filters(){
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
				'actions'=>array('create','update','creadetallecaja','rendicion','caja','admin','view','perfil'),
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




	public function actionCaja() {

           $codigotra=Yii::app()->user->um->getFieldValue(Yii::app()->user->id,'codtra');
		if(is_null($codigotra)){
			yii::app()->user->setFlash('notice'," Para usar esta función debes de ser un usuario, registrado como trabajador");
		}else{
			yii::app()->user->setFlash('success'," Tienes código de tabajador ".$codigotra);

			$this->render("cajamenor",array('codtrabajador'=>$codigotra));
		}

	}

	public function actionCreadetallecaja($id)
	{
		//el modelo padre es le registro del detalle caja chica que genero la deuda
		$modelopadre=Dcajachica::model()->findbypk($id);
		if(is_null($modelopadre)){
			throw new CHttpException(500,'No existe estaregistrop con este id');
		}else{
			//verificar que no sea otro usuario
			$codigotra=Yii::app()->user->um->getFieldValue(Yii::app()->user->id,'codtra');
			if(is_null($codigotra)){
				throw new CHttpException(500,' Eres usuario pero no estas registrado como trabajador  ');
				//yii::app()->user->setFlash('notice'," Eres usuario pero no estas registrado como trabajador  ");
			    //yii::app()->end();
			   }else {
				if(!$modelopadre->codtra==$codigotra) //Si le corresponde este registro
				{
					throw new CHttpException(500,' Estas intentando rendir una cuenta que no es la tuya  ');

					//yii::app()->user->setFlash('error'," Estas intentando rendir una cuenta que no es la tuya  ");
					//yii::app()->end();
				} else {
					$model=new Dcajachica;
					$model->setScenario('ins_rendiciontrabajador');
					$model->codtra=$codigotra;
					$model->hidcaja=$modelopadre->hidcaja;
					$model->hidcargo=$modelopadre->id;

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

			}

		}



	}

	public function actionRendicion($id) {

      $modelo=Dcajachica::model()->findByPk($id);
		if(is_null($modelo))
			throw new CHttpException(500,' El id al que haces referencia de la caja menor no existe');
      $this->render('_updatecaja',array('model'=>$modelo,'modelocabecera'=>$modelo->cabecera));

	}



	public function actionPerfil() {
		$model = Yii::app()->user->user;  // ciudado es: user->user, el cual da al CrugeStoredUser
		Yii::app()->user->um->loadUserFields($model); // le pedimos al api que carge los campos personalizados
		//$this->performAjaxValidation('crugestoreduser-form', $model);
		$postName = CrugeUtil::config()->postNameMappings['CrugeStoredUser'];
		if (isset($_POST[$postName])) {
			$model->attributes = $_POST[$postName];
			if ($model->validate()) {
				$newPwd = trim($model->newPassword);
				if ($newPwd != '') {
					Yii::app()->user->um->changePassword($model, $newPwd);
					Yii::app()->crugemailer->sendPasswordTo($model, $newPwd);
				}
				if (Yii::app()->user->um->save($model, 'update')) {
					Yii::app()->user->setFlash('profile-flash',
						'Tus datos de usuario han sido actualizados');
				}
			}
		}
		$this->render("profile",array('model'=>$model));
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
		$model=new Trabajadores;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Trabajadores']))
		{
			$model->attributes=$_POST['Trabajadores'];
			if($model->save()) {
                Yii::app()->user->setFlash('success', "..La carga inicial se ha anulado!");
				$this->redirect(array('update','id'=>$model->codigotra));
            }
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

		if(isset($_POST['Trabajadores']))
		{
			$model->attributes=$_POST['Trabajadores'];
            if($model->save()) {
                Yii::app()->user->setFlash('success', "..Los datos se han grabado!");
                $this->redirect(array('update','id'=>$model->codigotra));
            }
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
		$dataProvider=new CActiveDataProvider('Trabajadores');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Trabajadores('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Trabajadores']))
			$model->attributes=$_GET['Trabajadores'];

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
		$model=Trabajadores::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='trabajadores-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
