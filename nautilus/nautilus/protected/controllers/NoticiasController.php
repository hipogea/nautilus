<?php

class NoticiasController extends Controller
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
				'actions'=>array('admin','aprobar', 'descartar','tratarnoticia','poraprobar','configura','create','todosdeltablon','todos','useryaprobados','Adminusuariopendientes','update','solicita','inserta','adminuser'),
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
		$this->render('_formview',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Noticias;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Noticias']))
		{
			$model->attributes=$_POST['Noticias'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionSolicita()
	{
		$model=new Noticias;
		$model->setscenario('solicita');
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Noticias']))
		{
			
			$model->attributes=$_POST['Noticias'];
			if($model->save()) {
				Yii::app()->user->setFlash('success', 'La noticia se ha grabado correctamente, Tiene que esperar a que el administrador apruebe su solicitud, un correo ha sido enviado a su buzon');
				Yii::app()->crugemailer->mail_general(Confignoticias::getMailAdminTablon(),'Nueva solicitud de Noticia',$model->mensaje,$model,array('fecha','expira','fechapublicacion')) ;


				$this->redirect(array('view','id'=>$model->id));

			     }
		}

		$this->render('solicita',array(
			'model'=>$model,
		));
	}

public function actionConfigura(){
	$model=Confignoticias::model()->findBypK(1);
	if(isset($_POST['Confignoticias']))
	{
		$useractual=$model->iduseradm;
		$model->attributes=$_POST['Confignoticias'];
		if($model->save()) {
			Yii::app()->user->setFlash('success', 'Se ha configurado correctamente');
			if($useractual <> $model->iduseradm){
			  Yii::app()->crugemailer->mail_general(Yii::app()->user->um->loadUserById($model->iduseradm)->email,
				  'Cambio de administracion del Tablon',
				 'Eres el nuevo adminitrador del Tablon',$model,array('iduseradm')) ;
			}

			$this->redirect(array('todos'));

		}

	}
	$this->render('configura',array(
		'model'=>$model,
	));

}


	///Dtermina si el usuario en mencion es el admin del tablon
	/// Si no le pasa parametro IDUSER ASUME  que esta verificando para el usuario activo

	public function isAdminTablon($iduser=NULL){
		IF(is_null($iduser))
			$iduser=Yii::app()->user->id;

		if($iduser==Confignoticias::model()->findByPk(1)->iduseradm){
			return true;
		} else {
			return false;
		}


	}


	public function actiontratarnoticia($id){
         $id=(int)MiFactoria::cleanInput($id);
		 $model=$this->loadModel($id);
		if($model->isAdminTablon()){
			if($model->aprobado=='1'){
				yii::app()->user->setFlash('error', 'Está intentando modificar una noticia que ya está publicada');
				$this->redirect(array('view','id'=>$model->id));
			}else {
				if(isset($_POST['Noticias'])){
					$model->attributes=$_POST['Noticias'];
					if($model->save()){
						yii::app()->user->setFlash('success', ' El aviso se ha publicado ');
						$this->redirect(array('view','id'=>$model->id));
					}

				}


				$this->render('trataaviso',array('id'=>$id,'model'=>$model));



			}


		}else{
			yii::app()->user->setFlash('error', 'Esta acción es solo para el administrador del tablón');
			$this->redirect(array('view','id'=>$model->id));

		}


	}


	public function actionaprobar($id){
		$id=(int)MiFactoria::cleanInput($id);
		$model=$this->loadModel($id);
		$model->setScenario('tratamiento');
		$model->aprobado=1;
		$model->save();
		 yii::app()->user->setFlash('success', 'El aviso ha sido publicado');
		$this->redirect(array('view','id'=>$model->id));


	}

	public function actiondescartar($id){
		$id=(int)MiFactoria::cleanInput($id);
		$model=$this->loadModel($id);
		$model->setScenario('tratamiento');
		$model->aprobado=3;
		$model->save();
		yii::app()->user->setFlash('success', 'El aviso ha sido descartado');
		Yii::app()->crugemailer->mail_general(Confignoticias::getMailAdminTablon(),'Se ha descartado tu publicación',$model->mensaje,$model,array('fecha','expira','fechapublicacion')) ;

		$this->redirect(array('view','id'=>$model->id));


	}
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$id=(int)MiFactoria::cleanInput($id);
		$model=$this->loadModel($id);
		if ($model->IsOwner()){
			  if ($model->aprobado=='1'){
				  yii::app()->user->setFlash('notice', 'Su aviso ya ha sido publicado');
				  $this->redirect(array('view','id'=>$model->id));
			  }elseif($model->aprobado=='2'){
				  yii::app()->user->setFlash('notice', 'Su aviso ya se publicó ');
				  $this->redirect(array('view','id'=>$model->id));

			  }elseif($model->aprobado=='3'){
				  yii::app()->user->setFlash('notice', 'Su aviso ha sido descartado, publique otro ');
				  $this->redirect(array('view','id'=>$model->id));

			  }
			  elseif($model->aprobado=='0'){

				  if(isset($_POST['Noticias'])){
					  $model->attributes=$_POST['Noticias'];
					  if($model->save()){
						  yii::app()->user->setFlash('success', ' Su aviso se ha modificado ');
						  $this->redirect(array('view','id'=>$model->id));
					  }

				  }


					$this->render('update',array('id'=>$id,'model'=>$model));
			  }


		} else {
            yii::app()->user->setFlash('error', 'El aviso al que está intentando acceder no es el suyo');
			$this->redirect(array('admin'));
		}





		}


	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{

		$modelo=$this->loadModel($id);
		$rolotareauoperacion='ADMINISTRA_TABLON'; ///Esta cadena puede ser el nombre
		//De una TAREA , ROL u OPERACION, ...para este caso he colocado el nombre de una TAREA
		if( ($modelo->iduser==Yii::app()->user->id and $modelo->aprobado==0) or $this->isAdminTablon())
		{
			 $modelo->delete();
			$this->redirect('adminusuariopendientes');
		} else {
			throw new CHttpException(500,'Usted no puede borrar Avisos de otros Usuarios o Avisos que ya han sido aprobados.');
		}
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser

	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{

	}

	/**
	 * MOSMTRAR LOS QUE STA EN ALOIZARRA (VIGENTE Y APROBADO)
	 */
	public function actionAdmin()
	{
		$this->inserta();

	$model=new Noticias('searchtablon');

		if(isset($_GET['Noticias']))
			$model->attributes=$_GET['Noticias'];
          $proveedor=$model->searchtablon();
		$this->render('admin',array(
			'model'=>$model,
			'proveedor'=>$proveedor,
			'titulo'=>'Avisos Vigentes',
		));
	}

///LOQ UE ESTA PENDIENTE DE PUBLICAR POR EL USUARIO

	public function actionAdminusuariopendientes()
	{
		$this->inserta();
		$model=new Noticias('search_usuario_pendientes');

		if(isset($_GET['Noticias']))
			$model->attributes=$_GET['Noticias'];

		$proveedor=$model->search_usuario_pendientes();
		$this->render('admin',array(
			'model'=>$model,
			'proveedor'=>$proveedor,
			'titulo'=>'Tus avisos no aprobados',
		));
	}

///LO Q UE EL USUARIO DEBE VER: LO QUE HA SIOLICITADO(TODOS) + LO QUE SE HA PUBLICADO DE OTROS USUARIOS

	public function actionuseryaprobados()
    {
        $this->inserta();
        $model=new Noticias('search_loquedebever');

        if(isset($_GET['Noticias']))
            $model->attributes=$_GET['Noticias'];

		$proveedor=$model->search_loquedebever();
		$this->render('admin',array(
			'model'=>$model,
			'proveedor'=>$proveedor,
			'titulo'=>'Avisos que has publicado y otros que han sido apobados',
		));
    }

	///TODOS LOS AVISOS, DE TODOS LOS USUARIOS

	public function actiontodos()
	{
		$this->inserta();
		$model=new Noticias('searchsolicitados');

		if(isset($_GET['Noticias']))
			$model->attributes=$_GET['Noticias'];

		$proveedor=$model->searchsolicitados();
		$this->render('admin',array(
			'model'=>$model,
			'proveedor'=>$proveedor,
			'titulo'=>'Todos los Avisos',
		));
	}


	///TODOS LOS AVISOS, QU HAYAN PASADO PO EL ATBLON

	public function actiontodosdeltablon()
	{
		$this->inserta();
		$model=new Noticias('searchaprobados');

		if(isset($_GET['Noticias']))
			$model->attributes=$_GET['Noticias'];

		$proveedor=$model->searchaprobados();
		$this->render('admin',array(
			'model'=>$model,
			'proveedor'=>$proveedor,
			'titulo'=>'Avisos aprobados',
		));
	}



	///TODOS LOS AVISOS QUE ESTAN PENDIENTES DE APROBACION

	public function actionporaprobar()
	{
		$this->inserta();
		$model=new Noticias('searchporparobar');

		if(isset($_GET['Noticias']))
			$model->attributes=$_GET['Noticias'];

		$proveedor=$model->searchporaprobar();
		$this->render('admin',array(
			'model'=>$model,
			'proveedor'=>$proveedor,
			'titulo'=>'Avisos aprobados',
		));
	}


    ///BUsca si el dia hay un onomastico en la tabla trabajadores  lo inserta
    //en el AR()tablon 	public function inserta() {
     public function inserta(){
             MiFactoria::InsertaCumple();


	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Noticias the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Noticias::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Noticias $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='noticias-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
