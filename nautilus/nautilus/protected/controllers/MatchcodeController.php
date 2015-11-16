<?php

class MatchcodeController extends Controller
{
	

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

	
	
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('Visualiza','recibevalorsimple','Excel','defaulte','eliminasesiones','pide','pintamaterial','pintaactivo','pintaequipo','recibevalor1','creadetalle','relaciona1','Relaciona','Recibevalor','Recibevalores','create','update'),
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
	public function actionRelaciona()
	{
			$ordencampo=$_GET['ordencampo'];
			$campito=$_GET['campo'];
			$vvalore=$_GET[$_GET['contr']][$campito];

			//$clasi=$_POST['clasesita'];


		//$vvalore=$_POST[$_POST['contr']][$campito];
		$clasi=$_GET['clasesita'];


			//$contro=$_GET['contr'];
			//echo $vvalore;
			//echo $_POST[$_GET['contr']][$campito];
			//echo $_POST['Guia']['c_rsguia'];
			//$controlador=$_POST['pcontr'];
			//$campo=$_POST['pcampo'];

			/* echo "LA CLASE  ".$clasi."<br>";
		echo $campito."<br>";
		echo $vvalore."<br>";
		echo $ordencampo."<br>";*/
			// echo $campo;
			 //echo $_POST[$controlador][$campo];
			//echo $_POST[$contro][$campito];
			//echo $vvalore;
		echo $clasi::model()->findByPK($vvalore)->{$clasi::model()->attributeNames()[$ordencampo]};
			 // Yii::app()->explorador->buscavalor($campito,$vvalore,$ordencampo,$clasi);
			 //Fotos::buscavalor($campito,$vvalore,$ordencampo,$relaciones);
	}

public function actionRelaciona1()
	{


  /* print_r($_GET);
		yii::app()->end();*/
		$ordencampo=$_GET['ordencampo'];
			$campito=$_GET['campo'];
			$campolargo=$_GET['campolargo'];
			$vvalore=$_POST[$_GET['contr']][$campito];	
			$clasi=$_GET['clasesita'];


			//$form=$_GET['form'];	
			$contr=$_GET['contr'];
			// echo CHtml::textField($contr.'_'.$campito,Yii::app()->explorador->buscavalor($campito,$vvalore,$ordencampo,$clasi),
			 	//array('id'=>$contr.'_'.$campito));
			 //Fotos::buscavalor($campito,$vvalore,$ordencampo,$relaciones);
			//echo " type=text name='[".$contr."]".$campito."'   id='".$contr."_".$campito."'  size='40' value='".$vvalue."'  ";
			//echo "<input type=text name='[".$contr."]".$campito."'   id='".$contr."_".$campito."'  size='40' value='".Yii::app()->explorador->buscavalor1($campito,$vvalore,$ordencampo,$clasi)."' >";
		/*	echo "vvvalore=".$vvalore."<br>";
			echo "contr=".$contr."<br>";
			echo "ordencampo=".$ordencampo."<br>";
			echo "campito=".$campito."<br>";
			echo "clasi=".$clasi."<br>";*/
		//echo $clasi::model()->findByPK($vvalore)->{$clasi::model()->attributeNames()[$ordencampo]};



		if (isset($_GET['campoex'])){ //SIS SE DIO COMO DATO UN CAMPO QUE ON ES LA CLAVE PRINCIPAL DE LA LLAVE FORANEA USAR FIND
			$campoex=$_GET['campoex'];
			if(gettype($vvalore)=='string')
				$vvalore="'".$vvalore."'";
			$condicion="".$campoex."=".$vvalore;
			$modelin=$clasi::model()->find($condicion);

		}else { //SI NO SE HA DADO NADA SE ASUME QUE ES LA CLAVE PRINCIPAL

			$modelin=$clasi::model()->findByPk($vvalore);

		}


		   if(!is_null($modelin)){
			 $contenido= $modelin->{$clasi::model()->attributeNames()[$ordencampo]};
		   } else {
			  $contenido="--No hay resultados ";
			  // $contenido=$condicion;
		   }
		//$aponer= $clasi::model()->find("brevete='".trim($vvalore)."'")->{$clasi::model()->attributeNames()[$ordencampo]};
		Unset($modelin);
		//echo $contenido;
		echo "<input type=text name='".$contr."[".$campolargo."]'   id='".$contr."_".$campolargo."'  size='40' value='".$contenido."' >";

		//var_dump( );
		//var_dump($vvalore);
		//Yii::app()->explorador->buscavalor1($campolargo,$contr,$vvalore,$ordencampo,$clasi) ;
		//echo "<input type=text name='".$contr."[".$campito."]'   id='".$contr."_".$campito."'  size='40' value='".$aponer."' >";



	}


	public function actionRelacionas()
	{
			$ordencampo=$_POST['ordencampo'];
			$campito=$_POST['campo'];

			/*$ordencampo=$_GET['ordencampo'];
			$campito=$_GET['campo'];*/
			$vvalore=$_POST[$_GET['contr']][$campito];	
			/*$clasi=$_GET['clasesita'];	*/


			
			//$vvalore=$_POST[$_POST['contr']][$campito];						
			$clasi=$_POST['clasesita'];	

			ECHO "CONTROLADOR:  ".$_POST['contr']."<br>";
			
			ECHO "ORDEN CAMPO  :  ".$ordencampo."<br>";
			ECHO "CAMPITO :  ".$campito."<br>";

			ECHO "VALOR  :  ".$_POST[$_POST['contr']][$campito]."<br>";
			ECHO "CLASE  :  ".$clasi."<br>";
			//echo "hola";
			//echo gettype($_POST['clasesita']);
			  //Yii::app()->explorador->buscavalor($campito,$vvalore,$ordencampo,$clasi);
			 //Fotos::buscavalor($campito,$vvalore,$ordencampo,$relaciones);
	}

	public function actionRecibevalorSimple()
	{

		$autoIdAll=array();
		if(  isset($_GET['checkselected'])   ) //If user had posted the form with records selected
		{
			$autoIdAll = $_GET['checkselected']; ///The records selecteds
		};
		if(count($autoIdAll)>0)
		{
			echo CHtml::script("window.parent.$('#cru-dialog3').dialog('close');
																		window.parent.$('#cru-frame3').attr('src','');
																		var caja=window.parent.$('#cru-dialog3').data('hilo');
																		var valoresclave= new Array();
																		var controles=new Array();
																		var cadenita='{$autoIdAll[0]}';
																		var valoresclave=cadenita.split('_');
																		var controles=caja.split('@');
																		window.parent.$('#'+controles[0]+'').val(valoresclave[0]);
																		window.parent.$('#'+controles[1]+'').html(valoresclave[1]);
																		");
			//window.parent.$('#'+controles[1]+'').html(valoresclave[0]);
			//window.parent.$('#'+controles[0]+'').attr('value',valoresclave[0]);
			//
			Yii::app()->end();
		} else{

			//$relaciones=$_GET['relaciones'];
			//$modeliz=new Guia;
			//$relaciones=$modeliz->relations();
			$nombreclase=$_GET['clasesita'];
			//$tipodato=gettype(Yii::app()->explorador->devuelvemodelo($campo,$relaciones));
			//$model=Yii::app()->explorador->devuelvemodelo($campo,$nombreclase);
			$model=new $nombreclase;
			$model->unsetAttributes();
			if(isset($_GET[$nombreclase]))
				$model->attributes=$_GET[$nombreclase];
			$this->layout='//layouts/iframe' ;
			$this->render("ext.explorador.views.vw_".$nombreclase,array('model'=>$model));
			//$this->render("ext.explorador.views.vw_pruebitas1",array('tipodato'=>$tipodato,'tablita'=>$nombreclase,'campo'=>$campo,'relaciones'=>$relaciones));

		}

	}





	public function actionRecibevalor()
	{
		
		$autoIdAll=array();
		if(  isset($_GET['checkselected'])   ) //If user had posted the form with records selected
				{
				$autoIdAll = $_GET['checkselected']; ///The records selecteds 
				};
				if(count($autoIdAll)>0)
										{
												echo CHtml::script("window.parent.$('#cru-dialog3').dialog('close');													                    
																		window.parent.$('#cru-frame3').attr('src','');
																		var caja=window.parent.$('#cru-dialog3').data('hilo');
																		var valoresclave= new Array();
																		var controles=new Array();
																		var cadenita='{$autoIdAll[0]}';
																		var valoresclave=cadenita.split('_');	
																		var controles=caja.split('@');
																		window.parent.$('#'+controles[0]+'').val(valoresclave[0]);
																		window.parent.$('#'+controles[1]+'').html(valoresclave[1]);
																		");
											//window.parent.$('#'+controles[1]+'').html(valoresclave[0]);
											//window.parent.$('#'+controles[0]+'').attr('value',valoresclave[0]);
											//
														Yii::app()->end();
										} else{
												//$campo=$_GET['campo'];
												//$relaciones=$_GET['relaciones'];
												//$modeliz=new Guia;
												//$relaciones=$modeliz->relations();
												$nombreclase=$_GET['clasesita'];
												//$tipodato=gettype(Yii::app()->explorador->devuelvemodelo($campo,$relaciones));
												//$model=Yii::app()->explorador->devuelvemodelo($campo,$nombreclase);
												$model=new $nombreclase;
												$model->unsetAttributes(); 
												if(isset($_GET[$nombreclase]))
												$model->attributes=$_GET[$nombreclase];
												$this->layout='//layouts/iframe' ;
												$this->render("ext.explorador.views.vw_".$nombreclase,array('model'=>$model));
												 //$this->render("ext.explorador.views.vw_pruebitas1",array('tipodato'=>$tipodato,'tablita'=>$nombreclase,'campo'=>$campo,'relaciones'=>$relaciones));
												
												}
										
	}
	
	public function actionRecibevalor1()
	{
		
		$autoIdAll=array();
		if(  isset($_GET['checkselected'])   ) //If user had posted the form with records selected
				{
				$autoIdAll = $_GET['checkselected']; ///The records selecteds 
				};
				if(count($autoIdAll)>0)
										{
												echo CHtml::script("window.parent.$('#cru-dialog3').dialog('close');													                    
																		window.parent.$('#cru-frame3').attr('src','');
																		var caja=window.parent.$('#cru-dialog3').data('hilo');	15
																		var valoresclave= new Array();
																		var controles=new Array();
																		var cadenita='{$autoIdAll[0]}';
																		var valoresclave=cadenita.split('_');	
																		var controles=caja.split('@');	
																		window.parent.$('#'+controles[0]+'').val(valoresclave[0]);
																		window.parent.$('#'+controles[1]+'').attr('value',valoresclave[1]);
																		window.parent.$('#pio').attr('src','".Yii::app()->getTheme()->baseUrl.Yii::app()->params['rutatemaimagenes']."filter.png');
																		");
														Yii::app()->end();
										} else{
												$campo=$_GET['campo'];
												//$relaciones=$_GET['relaciones'];
												//$modeliz=new Guia;
												//$relaciones=$modeliz->relations();
												$nombreclase=$_GET['clasesita'];
												//$tipodato=gettype(Yii::app()->explorador->devuelvemodelo($campo,$relaciones));
												$model=Yii::app()->explorador->devuelvemodelo($campo,$nombreclase);												
												$model->unsetAttributes(); 
												if(isset($_GET[$nombreclase]))
												$model->attributes=$_GET[$nombreclase];
												$this->layout='//layouts/iframe' ;
												$this->render("ext.explorador.views.vw_".$nombreclase,array('model'=>$model));
												 //$this->render("ext.explorador.views.vw_pruebitas1",array('tipodato'=>$tipodato,'tablita'=>$nombreclase,'campo'=>$campo,'relaciones'=>$relaciones));
												
												}
										
	}
	

	public function actionRecibevalores()
	{
		
		$autoIdAll=array();
		if(  isset($_GET['checkselected'])   ) //If user had posted the form with records selected
				{
				$autoIdAll = $_GET['checkselected']; ///The records selecteds 
				};
				if(count($autoIdAll)>0)
										{
												echo CHtml::script("window.parent.$('#cru-dialog3').dialog('close');													                    
																		window.parent.$('#cru-frame3').attr('src','');
																		var caja=window.parent.$('#cru-dialog3').data('hilo');	
																		var valoresclave= new Array();
																		var controles=new Array();
																		var primervalor='{$autoIdAll[0]}';																		
																		var controles=caja.split('@');	
																		window.parent.$('#'+controles[0]+'').attr('value',primervalor);
																		window.parent.$('#pio').attr('src','".Yii::app()->getTheme()->baseUrl.Yii::app()->params['rutatemaimagenes']."filter.png');
																		window.parent.$('#pio2').attr('src','".Yii::app()->getTheme()->baseUrl.Yii::app()->params['rutatemaimagenes']."nofilter.png');
																		");
														//Creando la sesion 
													  if(!isset($_SESSION['sesion_'.$_GET['nombremodelo']])) {
													  	 $_SESSION['sesion_'.$_GET['nombremodelo']] = array();
                                                         // $_SESSION['sesion_'.$_GET['nombremodelo']]=$autoIdAll;
													  	   }else {

													  	   	// Yii::app()->session['sesion_maestrocompo']=Yii::app()->session['sesion_maestrocompo']+	$autoIdAll;	
													  	   }
                                             $_SESSION['sesion_'.$_GET['nombremodelo']]= array_merge($_SESSION['sesion_'.$_GET['nombremodelo']],$autoIdAll);
													  	   //	 Yii::app()->session['sesion_'.$_GET['nombremodelo']]=$autoIdAll;

                                                       // echo $_SESSION['sesion_'.$_GET['nombremodelo']];

														Yii::app()->end();
										} else{
												$campo=$_GET['campo'];
												//$relaciones=$_GET['relaciones'];
												//$modeliz=new Guia;
												//$relaciones=$modeliz->relations();
												$nombreclase=$_GET['clasesita'];
												//$tipodato=gettype(Yii::app()->explorador->devuelvemodelo($campo,$relaciones));
												$model=Yii::app()->explorador->devuelvemodelo($campo,$_GET['nombremodelo']);												
												//$m=$_GET['nombremodelo'];
												$model->unsetAttributes(); 
												if(isset($_GET[$nombreclase]))
												$model->attributes=$_GET[$nombreclase];
												$this->layout='//layouts/iframe' ;
												$this->render("ext.explorador.views.vw_multi_".$_GET['nombremodelo'],array('model'=>$model));
												 //$this->render("ext.explorador.views.vw_pruebitas1",array('tipodato'=>$tipodato,'tablita'=>$nombreclase,'campo'=>$campo,'relaciones'=>$relaciones));
												
												}
										
	}
	
	public function actioneliminasesiones(){
			unset($_SESSION['sesion_'.$_POST['sesion']]);

	}
}
