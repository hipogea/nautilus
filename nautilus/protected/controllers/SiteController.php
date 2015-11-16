<?php



class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),

			'coco'=>array(
                'class'=>'CocoAction',
            ),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{

		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		  //$this->layout = '//layouts/column_inicio';
		  if (Yii::app()->user->isGuest) {
		  					$this->redirect(Yii::app()->user->ui->loginUrl);
		            }else {

			               $this->Loginventario();
			 				 MiFactoria::InsertaCumple();
		            		$this->render('index');

		            }
		//$this->render('index');
		//Yii::app()->user->ui->loginUrl
		

	}
	public function actionMaestros()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		  //$this->layout = '//layouts/column_inicio';
		  if (Yii::app()->user->isGuest) {
		  					$this->redirect(Yii::app()->user->ui->loginUrl);
		            }else {
		            		$this->render('maestros');
		            		//$this->redirect('/verificar');
		            }
		//$this->render('index');
		//Yii::app()->user->ui->loginUrl
		
	}

    public function actionRevisamaletin()
    {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        //$this->layout = '//layouts/column_inicio';
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->user->ui->loginUrl);
        }else {
            $this->layout = '//layouts/iframe';

            //preparando el array de solpes;
            $arraysolpes=array();
            $arraycompras=array();
             if(isset(Yii::app()->session['DOC350'])) {
                 $criteria=new CDbCriteria;
                 $criteria->addInCondition('id', Yii::app()->session['DOC350']);
                    $items=Desolpe::model()->findAll($criteria);
                             for ($i=0; $i < count($items); $i++) {
                                 $valordeltexto=$items[$i]['id'].'-'.$items[$i]['item'].'-'.$items[$i]['txtmaterial'];
                                 array_push($arraysolpes, array("text"=>$valordeltexto));

                             }
             }
            //preparando el array de compras;

            if(isset(Yii::app()->session['DOC220'])) {
                $criteria=new CDbCriteria;
                $criteria->addInCondition('id',Yii::app()->session['DOC350']);
                $items2=Docompra::model()->findAll($criteria);
                for ($i=0; $i < count($items2); $i++) {
                    $valordeltexto=$items2[$i]['id'].'-'.$items2[$i]['item'].'-'.$items2[$i]['descri'];
                    array_push($arraycompras, array("text"=>$valordeltexto));

                }
            }
            $this->render('treeviewdocs',array('items'=>$items,'arraycompras'=>$arraycompras,'arraysolpes'=>$arraysolpes));
            //$this->redirect('/verificar');
        }
        //$this->render('index');
        //Yii::app()->user->ui->loginUrl

    }



	/*Insert alo valores del inventario actual, 2 veces ppor semana cada 4 dias
	si ya hay entonces ignorarlo*/
	public function Loginventario(){
		$tiempo=time();
		$dia=date('d');
		$mes=date('m');
		$ani=date('y');
		$fecmax=Yii::app()->db->createCommand()
			->select('max(fecha)')
			->from('{{montoinventario}} a')
			->queryScalar();
		$tiempoult=strtotime($fecmax.'');
		if(($tiempo-$tiempoult) > 60*60*24*3 ){
			$alin=new Alinventario();
			$stocks=$alin->getStockValAlmacen();


			foreach ($stocks as $filastock)
			{
				$registro=new Montoinventario();

				$registro->setAttributes(
					array(
						'dia'=>$dia,
						'mes'=>$mes,
						'anno'=>$ani,
						'iduser'=>Yii::app()->user->id,
						'montolibre'=>round($filastock['stock_cantlibre'],0),
						'montotran'=>round($filastock['stock_canttran'],0),
						'montoreserva'=>round($filastock['stock_cantreserva'],0),
						'montodif'=>0,
						'montototal'=>round($filastock['stock_total'],2),
						'codal'=>$filastock['codalm'],
						'codcen'=>$filastock['codcen'],
						'fecha'=>date("Y-m-d"),
					)
				);
				if(!$registro->save())
				{
					print_r($registro->geterrors());
					yii::app()->end();
				}
				//$almacenes=Yii::app()->db->createCommand("SELECT *FROM public_almacenes ")->queryAll();
				/*print_r($filastock);
				echo "<br>";
				print_r($registro->attributes);
				echo "<br>";
				print_r($registro->geterrors());
				yii::app()->end();*/
			}
		}


	}


	public function actionConfig()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		  //$this->layout = '//layouts/column_inicio';
		  if (Yii::app()->user->isGuest) {
		  					$this->redirect(Yii::app()->user->ui->loginUrl);
		            }else {
		            		$this->render('config');
		            		//$this->redirect('/verificar');
		            }
		//$this->render('index');
		//Yii::app()->user->ui->loginUrl
		
	}


	public function actionAgregafavorito()

	{
				$model=new Usuariosfavoritos;
				$vaccion=$_GET['maccion'];
			$vcontrolador=$_GET['mcontrolador'];
			$url=Yii::app()->baseUrl.DIRECTORY_SEPARATOR.$vcontrolador.DIRECTORY_SEPARATOR.$vaccion;
			
			if(isset($_POST['Usuariosfavoritos'])) {
				                $model->attributes=$_POST['Usuariosfavoritos'];
										$model->save();
									echo CHtml::script("window.parent.$('#cru-dialoggeneral').dialog('close');
										window.parent.$('#cru-framegeneral').attr('src','');
										window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');");
														Yii::app()->end();


			}

		//	if (!empty($_GET['asDialog']))
					$this->layout = '//layouts/iframe';
		$this->render('_form_favoritos',array('model'=>$model,'url'=>$url));

		
	}


	public function actioncargaestado()
	{

		$valor=$_POST['Opcionesbarra']['codocu'];
		$criteria = new CDbCriteria();
		$criteria->addCondition("codocu=:vcodocu");
		$criteria->params=array(":vcodocu"=>$valor);
		$data=CHtml::listData(	Estado::model()->findAll($criteria),
			//$data=CHtml::listData(	Direcciones::model()->findAll(),
			"codestado",
			"estado"

		);
		echo CHtml::tag('option', array('value'=>null),CHtml::encode('Escoja el estado'),true);
		foreach($data as $value=>$name) {
			echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
		}
	}









	public function actionColocatipocambio()

	{
				//$model=new Tipocambio();
				//$vaccion=$_GET['maccion'];
			//$vcontrolador=$_GET['mcontrolador'];
			//$url=Yii::app()->baseUrl.DIRECTORY_SEPARATOR.$vcontrolador.DIRECTORY_SEPARATOR.$vaccion;
		$monedaalterna=Yii::app()->params['monedaalternativa'];
		$model=Tipocambio::model()->find("codmon2='".$monedaalterna."'");
		$model->setScenario('insert');
		$model->compra=yii::app()->tipocambio->getcompra($monedaalterna);
		$model->venta=round(1/yii::app()->tipocambio->getventa($monedaalterna),2);
		// $this->performAjaxValidation($model);
			if(isset($_POST['Tipocambio'])) {
				                $model->attributes=$_POST['Tipocambio'];
				                if ($model->validate()) {

										yii::app()->tipocambio->setcompra('USD',$model->compra);
									    yii::app()->tipocambio->setventa('USD',$model->venta);
									echo CHtml::script("window.parent.$('#cru-dialoggeneral').dialog('close');
										window.parent.$('#cru-framegeneral').attr('src','');
										window.parent.$('#zonaventa').html('{$model->venta}');
										window.parent.$('#zonaultima').html('{$model->ultima}');
										window.parent.$('#zonacompra').html('{$model->compra}');");

														Yii::app()->end();
									}

			}

		//	if (!empty($_GET['asDialog']))
					$this->layout = '//layouts/iframe';
		$this->render('_form_tipocambio',array('model'=>$model));

		
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}


	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionfinsesion()
	{

		$this->redirect(Yii::app()->homeUrl);
	}



}


