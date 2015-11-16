<?php

class AlinventarioController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	public function filters()
	{
		return array('accessControl',array('CrugeAccessControlFilter'));
	}


	public function behaviors() {
		return array(

			'exportableGrid' => array(
				'class' => 'application.components.ExportableGridBehavior',
				'filename' => 'Inventariomareriles.csv',
				'csvDelimiter' =>(Yii::app()->user->isGuest)?",":Yii::app()->user->getField('delimitador') , //i.e. Excel friendly csv delimiter
			));
	}





	public function actionhistorinventario (){

		$cantidadregistros=Yii::app()->db->createCommand()->select("id")
			->from( "{{opcionesdocumentos}}" )
			->where("idopoc=v:idop",array("v:idop"=>$fila->id))
			->queryScalar();

		$user = Yii::app()->db->createCommand()
			->select('id, username, profile')
			->from('tbl_user u')
			->join('tbl_profile p', 'u.id=p.user_id')
			->where('id=:id', array(':id'=>$id))
			->queryRow();

		$montosmensualesporgrupo=Yii::app()->db->createCommand()
			->select('avg(montolibre)as smontolibre,
			    avg(montoreserva)as smontoreserva,
			    avg(montotran)as smontotran,
			   avg(montodif)as smontodif,
			    a.codal,
			    a.anno,
			    a.codcen,
			    a.mes,
			    a.codgrupo
			    b.destipo
			       ')
			->from('{{montoinventario}} a ,{{maestrotipos}} b')
			->where('b.codtipo=a.codgrupo')
			->group('a.codal,  a.codcen,  a.mes,a.anno, a.codgrupo,b.destipo')
			->queryRow();

		$montosmensuales=Yii::app()->db->createCommand()
			->select('avg(montolibre)as smontolibre,
			    avg(montoreserva)as smontoreserva,
			    avg(montotran)as smontotran,
			    avg(montodif)as smontodif,
			    a.codal,
			    a.codcen,
			    a.mes,
			    a.anno
			       ')
			->from('{{montoinventario}} a ')
			->group('a.codal,  a.codcen,  a.mes ,a.anno')
			->queryRow();

        $inventarioactual=
		$montosanuales=Yii::app()->db->createCommand()
			->select('avg(montolibre)as smontolibre,
			    avg(montoreserva)as smontoreserva,
			   avg(montotran)as smontotran,
			   avg(montodif)as smontodif,
			    a.codal,
			    a.codcen
			    a.anno
			       ')
			->from('{{montoinventario}} a ')
			->group('a.codal,  a.codcen, a.anno')
			->queryRow();



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

			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('admin','create','supervision','import','pronostica','pareto','adminpareto','repinventario','prueba','buclecarga','update','cargarmat','busqueda','cargaalmacenes','cargaalmacenes1'),
				'users'=>array('@'),
			),


			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}




	public function actionImport(){
       $model=new Alinventario;
		$model->setScenario("cargamasiva");
 if(isset($_POST['Alinventario']))
 {
	 echo " Si salio el POST                             OK ->   ";
  $model->attributes=$_POST['Alinventario'];
           $filelist=CUploadedFile::getInstancesByName('csvfile');
          // if($filelist)
			  // $model->csvfile=1;
           //if($model->validate())
          // {
			  // echo " Se valido  ....";
               foreach($filelist as $file)
               {

				   try{
                   $transaction = Yii::app()->db->beginTransaction();
                   $handle = fopen("$file->tempName", "r");
					   echo "el handle  es ....".gettype($handle);
                   $row = 1;
                   while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                       if($row>1){
                             $newmodel=Alinventario::model()->findByPk($data[0]);
						     $newmodel->setScenario("cargamasiva");
						     $newmodel->cantlibre=$data[1];
						     echo " el id  a cargar es :  ".$data[0]."   \n";
                             if($newmodel->save()) {
								 echo " grabo  carajo --------------------> :  ".$data[1]."   \n";
							 } else {
								 echo " NO grabo  xxxxxxxxxxx-> :  ".$data[1]."   \n";
							 }
                       }
                       $row++;
                   }
                   $transaction->commit();
                   }catch(Exception $error){
                       print_r($error);
                       $transaction->rollback();
                   }
				   yii::app()->end();
               }
           //} else

		  // {
			 //  echo "NO se valido CSM ";
			   //yii::app()->end();
		   //}
 } else  {
	echo "NO se ha enviado ningun form";
	//yii::app()->end();
 }
 $this->render('cargainventario',array(
  'model'=>$model,
 ));
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

    public function actionPrueba()
    {
print_r($_SESSION['sesion_Maestrocompo']);

    }
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Alinventario;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Alinventario']))
		{
			$model->attributes=$_POST['Alinventario'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

  
	public function actioncargarmat() {

					$modelito=new cargainForm;



		// collect user input data
		if(isset($_POST['cargainForm']))
		{
           // Yii::app()->end();
			$modelito->attributes=$_POST['cargainForm'];
			// validate user input and redirect to the previous page if valid
            //obtenemos la matriz de datos del maestro de materiales que no esta ampliado en ese centro y almacen
            $prefix="public_";

			$matriz2=Yii::app()->db->createCommand(" SELECT *from ".$prefix."maestrocomponentes where codigo not in (
                   select codart from ".$prefix."alinventario where codalm='".$modelito->almacen."'  and codcen='".$modelito->centro."'
                 ) ")->queryAll();

			for ($i=0; $i < count($matriz2); $i++) { //recorremos y lo vamos insertando
				$cadena="INSERT INTO ".$prefix."alinventario ( CODCEN,CODALM,CODART, CANTLIBRE,CANTTRAN,CANTRES) VALUES ('".$modelito->centro."','".$modelito->almacen."','".$matriz2[$i]['codigo']."',0,0,0)";
				$command = Yii::app()->db->createCommand($cadena);
				$command->execute();
				/* $cadena2="select codart from ".$prefix."alinventario where codalm='".$modelito->almacen."'  and codcen='".$modelito->centro."'";
                     $command1 = Yii::app()->db->createCommand($cadena2)->queryScalar();
                     if($command1) { ///si no encontro un registro en el inventario entonces

                     }*/
			}


             $matriz=Yii::app()->db->createCommand(" SELECT *from ".$prefix."maestrocomponentes where codigo not in (
                    SELECT codart from ".$prefix."maestrodetalle where codcentro='".trim($modelito->centro)."' and  codal ='".trim($modelito->almacen)."'
                 ) ")->queryAll();

            for ($i=0; $i < count($matriz); $i++) { //recorremos y lo vamos insertando
                   $cadena="INSERT INTO ".$prefix."maestrodetalle ( CODCENTRO,CODAL, CODART,CODGRUPOVENTAS,CANALDIST,CANTECONOMICA,CANTREPOSIC,CANTREORDEN,LEADTIME) VALUES ('".$modelito->centro."','".$modelito->almacen."','".$matriz[$i]['codigo']."', '001','02',0,0,0,0)";
                        $command = Yii::app()->db->createCommand($cadena);
				        $command->execute();
                      /* $cadena2="select codart from ".$prefix."alinventario where codalm='".$modelito->almacen."'  and codcen='".$modelito->centro."'";
                         $command1 = Yii::app()->db->createCommand($cadena2)->queryScalar();
				         if($command1) { ///si no encontro un registro en el inventario entonces

                         }*/
                 }



			$matriz3=Yii::app()->db->createCommand(" SELECT *from ".$prefix."maestrocomponentes where codigo not in (
                    SELECT hcodart from ".$prefix."maestrodetallecentros where codcen='".trim($modelito->centro)."' ) ")->queryAll();

			for ($i=0; $i < count($matriz3); $i++) { //recorremos y lo vamos insertando
				$cadena="INSERT INTO ".$prefix."maestrodetallecentros
				( catvalor,codcen,hcodart,iqf)
				 VALUES (null, '".$modelito->centro."','".$matriz3[$i]['codigo']."', '0')";
				$command = Yii::app()->db->createCommand($cadena);
				$command->execute();
				/* $cadena2="select codart from ".$prefix."alinventario where codalm='".$modelito->almacen."'  and codcen='".$modelito->centro."'";
                     $command1 = Yii::app()->db->createCommand($cadena2)->queryScalar();
                     if($command1) { ///si no encontro un registro en el inventario entonces

                     }*/
			}


				  $this->render("vw_procesado");
		}
		// display the login form
		$this->render('cargamat',array('model'=>$modelito));
	                          }

    public function buclecarga($centro,$almacen) {
         $prefix="public_";
        $matrizmateriales=Yii::app()->db->createCommand(" SELECT *from ".$prefix."maestrocomponentes where codigo not in (
        SELECT codart from ".$prefix."maestrodetalle where codcentro='".$centro."' and  codal ='".$almacen."'
        ) ")->queryAll();

        return $matrizmateriales;
    }





	public function actioncargaalmacenes()
	{
		$criteria = new CDbCriteria();
		$criteria->addCondition("codcen=:proved");
		$valor=$_POST['cargainForm']['centro'];
		//echo $valor;
		$data=CHtml::listData(	Almacenes::model()->findAll(  "codcen='".$valor."'"),
		  //$data=CHtml::listData(	Direcciones::model()->findAll(),
												"codalm",
												"nomal"
											
												); 
			echo CHtml::tag('option', array('value'=>null),CHtml::encode('Escoja un almacen'),true);
			foreach($data as $value=>$name) { 
			    echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
			   } 
	}
	

	public function actioncargaalmacenes1()
	{
		$criteria = new CDbCriteria();
		$criteria->addCondition("codcen=:proved");
		$valor=$_POST['cargainForm']['centro'];
		//echo "el valor es ..".$valor;
        //Yii::app()->end();
		  $data=CHtml::listData(	Almacenes::model()->findAll(  "codcen='".$valor."'"),
		  //$data=CHtml::listData(	Direcciones::model()->findAll(),
												"codalm",
												"nomal"
											
												); 
			echo CHtml::tag('option', array('value'=>null),CHtml::encode('Escoja un almacen'),true);
			foreach($data as $value=>$name) { 
			    echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
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

		if(isset($_POST['Alinventario']))
		{
			$model->attributes=$_POST['Alinventario'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('detalleinventario',array(
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
		$dataProvider=new CActiveDataProvider('Alinventario');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{


		$model=new VwAlinventario('search');
		$model->unsetAttributes();  // clear any default values
	
		if(isset($_GET['VwAlinventario'])){
			$model->attributes=$_GET['VwAlinventario'];

		}

		if ($this->isExportRequest()) { //<==== [[ADD THIS BLOCK BEFORE RENDER]]
			$this->exportCSV($model->search(), array(
					'idinventario',
					'codalm',
					'codcen',
					'ubicacion',
					'desum',
					'um',
					'codart',
					'descripcion',
					'cantlibre',
					'cantres',
					'canttran',
					'punit',
					'lote',
				)

			);
		} else {
			$this->render('admin',array(
				'model'=>$model,
			));
			/*echo "no pasa nada ";
			Yii::app()->end();*/
		}


	}


///funcion para mostrar el llistadp o ranking de pareto
	public function actionAdminpareto()
	{
		$model=new VwPareto('search');
		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['VwPareto'])){
			$model->attributes=$_GET['VwPareto'];
			if ($this->isExportRequest()) { //<==== [[ADD THIS BLOCK BEFORE RENDER]]
				//set_time_limit(0); //Uncomment to export lage datasets
				//Add to the csv a single line of text
				//  $this->exportCSV(array('POSTS WITH FILTER:'), null, false);
				//Add to the csv a single model data with 3 empty rows after the data
				// $this->exportCSV($model, array_keys($model->attributeLabels()), false, 3);
				//Add to the csv a lot of models from a CDataProvider

				$this->exportCSV($model->search(), array('codalm','codart','codcen','desum','cantlibre','punit','descripcion','ptlibre','ubicacion','ranking','clase','acumulado','porcentaje','hidventario','porcentajeac'));
			}

		}

		$this->render('vwlistadopareto',array(
			'model'=>$model,

		));
	}




	/**
	 * Pinta el pareto
	 */
	public function actionPareto()
	{
		$modinventario=new Alinventario();

		$model=new ParetoForm;

		// collect user input data
		if(isset($_POST['ParetoForm']))
		{

			$model->attributes=$_POST['ParetoForm'];
			$almacen=$_POST['ParetoForm']['almacen'];
			$centro=$_POST['ParetoForm']['centro'];
			$tipo=$_POST['ParetoForm']['codtipo'];
			$almacen=MiFactoria::cleanInput($almacen);
			$centro=MiFactoria::cleanInput($centro);
	if($model->validate()) {
				ini_set ("set_time_limit" , 0);
					if(is_null($tipo))   {
				  $valortotal=$modinventario->getStockValAlmacen($almacen/*,$centro*/);
				} else  {
						$valortotal=$modinventario->getStockValAlmacen($almacen/*,$centro*/);
					}

		$rows= Yii::app()->db->createCommand()
			->select('a.id, ('.$modinventario->getcadenacampos().')*a.punit*b.cambio as stock,
			    a.codalm,a.codart,
			    a.codcen')
			->from('{{alinventario}} a ,{{tipocambio}} b , {{almacenes}} c')
			->where("a.codalm=c.codalm and a.codcen=c.codcen and
		  c.codmon=b.codmon1 and b.codmon2=:Vmonedadefault  and a.codalm=:vcodal and (".$modinventario->getcadenacampos().") > 0 ",
				array(":vcodal"=>$almacen,":Vmonedadefault"=>yii::app()->settings->get('general','general_monedadef')))
			//->group('a.codalm, a.codcen,a.codart,c.nomal')
			->order('('.$modinventario->getcadenacampos().')*a.punit*b.cambio DESC')
			->queryAll();
				///borramos todos los registros anteriores primero
		$comando=Yii::app()->db->createCommand(" delete from {{pareto}} ");
				// $comando=Yii::app()->db->createCommand(" delete from {{pareto}}  where
				   // hinventario in (SELECT id from ".Yii::app()->params['prefijo']."alinventario where codcen='".$centro."'  and codalm ='".$almacen."' ) ");
				$comando->execute();
					$i=1; //ranking
				$acumulado=0; //valor del stcok acumulado
				$porcenacumulado=0;
				//$transaction = $this->getDbConnection()->beginTransaction();
				foreach($rows as $valor) {
					$acumulado=$acumulado+$valor['stock'];
					/*var_dump($valortotal[$almacen]['stock_total']);
					yii::app()->end();*/
					$porcentaje=round($valor['stock']/$valortotal[$almacen]['stock_total'],3);
					$porcenacumulado=round($porcenacumulado+$porcentaje,2);
					$comando1=Yii::app()->db->createCommand(" INSERT INTO {{pareto}} (hinventario,ranking, clase, acumulado,porcentaje,porcentajeac,  idsesion) values( ".$valor['id']." , ".$i.",'', ".$acumulado.",".$porcentaje.",".$porcenacumulado.",".Yii::app()->user->getId()."  ) ");
					$comando1->execute();
					//$transaction->commit();
					$i=$i+1;
				}


				//luego establecer los margenes de la clase
				$rangoa=$_POST['ParetoForm']['rangoa']/100;
				$rangob=$_POST['ParetoForm']['rangob']/100;
				$rangoc=$_POST['ParetoForm']['rangoc']/100;

				//actualñizar todas las clases A
				$comando2=Yii::app()->db->createCommand(" UPDATE ".Yii::app()->params['prefijo']."pareto SET clase='A' where porcentajeac < ".$rangoa."  ");
				$comando2->execute();

				//actualñizar todas las clases B
				$comando2=Yii::app()->db->createCommand(" UPDATE ".Yii::app()->params['prefijo']."pareto SET clase='B' where porcentajeac >=".$rangoa." and porcentajeac < ".($rangoa+$rangob)." ");
				$comando2->execute();

				//actualñizar todas las clases C
				$comando2=Yii::app()->db->createCommand(" UPDATE ".Yii::app()->params['prefijo']."pareto SET clase='C' where porcentajeac >=".($rangoa+$rangob)." ");
				$comando2->execute();

				//$this->render('vwlistadopareto');
				//$this->render('vwpareto',array('model'=>$model));
				//$this->redirect('vwpareto',array('model'=>$model));
				$this->redirect(array('adminpareto'));
					}

			//echo "ESTOS SON LOS RANGOS  ".$rangoa."    ".$rangob."    ".$rangoc;
				//Yii::app()->end();

	}
		// display the login form
		$this->render('pareto_form',array('model'=>$model));


	}


	public function actionGraficopareto()
	{

		$cuantoshay=Yii::app()->db->createCommand(" select count(*) from ".Yii::app()->params['prefijo']."pareto where  idsesion=".Yii::app()->user->getId()."  ")->queryScalar();
		$precision=round($cuantoshay/50,0);
		//sacando los registros para el grafico
		$puntosxy=Yii::app()->db->createCommand(" select ranking , acumulado  from ".Yii::app()->params['prefijo']."pareto   where  MOD (ranking,".$precision." )=0 and    idsesion=".Yii::app()->user->getId()." ")->queryAll();



	}



public function actionBusqueda()
	{

		$model=new VwAlinventario;
		// collect user input data
		if(isset($_POST['VwAlinventario']))
		{

			$model->attributes=$_POST['VwAlinventario'];
			// validate user input and redirect to the previous page if valid
			//if($model->validate() && $model->login())
				//$this->redirect(Yii::app()->user->returnUrl);
			$proveedor=$model->search();
			/*$criterio=$proveedor->getCriteria();
			$criterio->select=" SUM(PUNIT*(CANTRES+PTLIBRE)) ";
			$totalinventario=$model->findall($criterio);*/
			$this->render('admin',array(
							'model'=>$model,
							'proveedor'=>$proveedor,
							//'total'=>$totalinventario,
				)

				);
			Yii::app()->end();
		}
         
		if(isset($_GET['VwAlinventario']))
		{
			$model->attributes=$_GET['VwAlinventario'];
			// validate user input and redirect to the previous page if valid
			//if($model->validate() && $model->login())
				//$this->redirect(Yii::app()->user->returnUrl);
			$proveedor=$model->search();
			/*$criterio=$proveedor->getCriteria();
			$criterio->select=" SUM(PUNIT*(CANTRES+PTLIBRE)) ";
			$totalinventario=$model->findall($criterio);*/
			$this->render('admin',array(
							'model'=>$model,
							'proveedor'=>$proveedor,
							//'total'=>$totalinventario,
				)

				);
			Yii::app()->end();
		}


		// display the login form
		$this->render('busqueda',array('model'=>$model));
		
	}

	
	public function actionRepinventario()
	{
	/* $ancho=$this->model()->search_parametros($idtemporada,$idespecie,$codep)->getdata();
			// echo count($ancho);
			 //obteniendo las fechas 
				
		if (count($ancho) >0 and sort($ancho)) {
				$fechas=array()	; //las absicas
					$pescas=array(); //para guardar la pesca descragada
					$combustibles=array(); //para guardar los petroleso consumidos 
					$combustiblesporhora=array(); //petrole por hora 
					$combustibleportonelada=array();//petroleo por hora 
					$eficiencias=array();//eficiencias de bodega 
					$horastrabajadas=array();//hora trabajadas 
					
					//$acumulado=array();
					$meta=array();
							$i=0;
								foreach ($ancho as $clave => $valor) {
											$fechas[$i]=substr($ancho[$i]['fecha'],5,5)	;
											$pescas[$i]=$ancho[$i]['sdescargada']+0	;
											$combustibles[$i]=$ancho[$i]['sd2']+0	;
											$combustiblesporhora[$i]=$ancho[$i]['d2porhora']+0	;
											$combustibleportonelada[$i]=$ancho[$i]['sct']+0	;
											$eficiencias[$i]=$ancho[$i]['eficienciabodega']+0	;
											$horastrabajadas[$i]=$ancho[$i]['horasta']+0	;
											$i=$i+1;
													}
	  return array(
					'nombrebarco'=>$ancho[0]['nomep'],
					'fechas'=>$fechas, //las absicas
					'pescas'=>$pescas, //para guardar la pesca descragada
					'combustibles'=>$combustibles, //para guardar los petroleso consumidos 
					'combustibleporhora'=>$combustiblesporhora, //petrole por hora 
					'combustibleportonelada'=>$combustibleportonelada,//petroleo por hora 
					'eficiencias'=>$eficiencias,//eficiencias de bodega 
					'horastrabajadas'=>$horastrabajadas,//hora trabajadas 
					);
					
					}else {
					return null;
					}
	 */
	
	//$matrizstockalmacenes= Yii::app()->db->createCommand('select sum(stocktotal) as stock,codalm,codcen  from Vw_alinventario_resumen group by codalm, codcen ')->queryAll();
	$matrizstockcentros=Yii::app()->db->createCommand('select sum(stocktotal) as stock,codcen from Vw_alinventario_resumen group by  codcen ')->queryAll();
	$matrizstocktotal=Yii::app()->db->createCommand('select sum(stocktotal) as stock from Vw_alinventario_resumen ')->queryAll();
	
	for ($i=0; $i < count($matrizstockcentros); $i++) { 
	              $almacenesf=Yii::app()->db->createCommand("select distinct codalm  from Vw_alinventario_resumen where codcen='".$matrizstockcentros[$i]['codcen']."' order by codalm asc")->queryAll();
			      $stocksf=Yii::app()->db->createCommand("select sum(stocktotal) as stock , codalm  from Vw_alinventario_resumen where codcen='".$matrizstockcentros[$i]['codcen']."' group by codalm order by codalm asc")->queryAll();
			  
						 $almacenes=array();
						   $stocks=array();
						   for ($k=0; $k < count($almacenesf); $k++) { 
											array_push($almacenes, $almacenesf[$k]['codalm']);
											array_push($stocks, round($stocksf[$k]['stock'],1)+0);
										}
			 
		         $this->render('vw_indicador_por_centro',array(
			  'nombrecentro'=>$matrizstockcentros[$i]['codcen'],
				'almacenes'=>$almacenes,
				'stocks'=>$stocks,
			    'stockcentro'=>$matrizstockcentros[$i]['stock'],
			  'stocktotal'=>$matrizstocktotal[0]['stock'],
			  )
			                   );
							  
		  }
		 } 
	/*  $matriz=VwAlinventarioResumen::Model()->findall();
	  echo count($matriz);
	  echo array_sum($matriz[0]);
	           //matriz por centro 
	//  $matrizcentro=array_column($matriz,6);
	
	
		//$this->render('vw_indicador_por_centro');
		*/
	
	
	
	
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Alinventario the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Alinventario::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Alinventario $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='alinventario-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionPronostica()
	{
         $id=(int)$_POST['id'];
		$codmo=(int)$_POST['codmo'];

		var_dump($id);
		echo "<br>";
		var_dump($codmo);
		echo "<br>";

          $id=(int)MiFactoria::cleanInput($id);
		$modinventario=  $this->loadModel($id);
		$datosparagrafico=$modinventario->pronostico($codmo);
		//var_dump($datosparagrafico);

		echo $this->renderpartial ("vw_pronosticografico",array('model'=>$modinventario,'datosparagrafico'=>$datosparagrafico),true);

	}

	public function actionsupervision(){


          }


	public function actionCrealote(){


	}



}
