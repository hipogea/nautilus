<?php
const ESTADO_PREVIO='99';
const ESTADO_CREADO='10';
const ESTADO_AUTORIZADO='20';
const ESTADO_ANULADO='30';
const CODIGO_MATERIAL_SERVICIO='10000001';
const CODIGO_DOC_SOLPE='340';

const ESTADO_RESERVA_CREADO='10';
const ESTADO_RESERVA_ATENDIDO='20';
const ESTADO_RESERVA_ANULADO='30';
const ESTADO_RESERVA_CERRADO='70';



class SolpeController extends Controller
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
		Yii::app()->user->loginUrl = array("/cruge/ui/login");
		return array(

			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('admin','pideoferta','cargaimputacion', 'index','create','detienereserva','tratareserva','creaservicio','display','reservaautomatica','cargafavorito','creafavorito','vre','Pintamensajes','muestra','limpiarcarro','cargapanel','poneralcarro','tomarcompras','anulareserva','Solpeautomatica','imprimir2','atiendesolpe','stock','pasacompra','peru','anularsolpe','reservaitem','verificadispo','cargadetalle','aprobarsolpe','procesarsolpe','creadetalle','update','liberacion','aprobar','configuraop','Borraitems','modificadetalle'),
				'users'=>array('@'),
			),

			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

  public function behaviors() {
        return array(
            'exportableGrid' => array(
                'class' => 'application.components.ExportableGridBehavior',
                'filename' => 'Solicitudes.csv',
				'csvDelimiter' =>(Yii::app()->user->isGuest)?",":Yii::app()->user->getField('delimitador') , //i.e. Excel friendly csv delimiter

			),

			'doblepost'=>array(
				'class'=>'application.components.VerificaDoblePostBehavior'
						),



			);
    }


	public function devuelvehijos($id){
		$registroshijos =Desolpe::model()->findAllBySql(" select *from
  																".Yii::app()->params['prefijo']."desolpe1
  																 where
  																 hidsolpe=".$id." and est <> '20'  ");
		Return  $registroshijos;

	}

	public  function devuelveinventario($centro,$almacen,$codigo)
	{
		$criteria=new CDbCriteria;
		$criteria->addcondition("codcen=:vcodcen",'AND');
		$criteria->addcondition("codalm=:vcodalm",'AND');
		$criteria->addcondition("codart=:vcodart");
		$criteria->params=Array(":vcodcen"=>trim($centro),":vcodalm"=>trim($almacen),":vcodart"=>trim($codigo));
		$registro=Alinventario::model()->find($criteria);
		return (!is_null($registro))?$registro:0;

	}



	public function actionreservaautomatica($id) {
		$model=Solpe::model()->findByPk($id);
		if($model->escompra=='0') {  //Solo solpes que no sean de compras
		//
		$mensa="";
		$registroshijos=$model->solpe_desolpe;
		$transaccion=$model->dbConnection->beginTransaction();
		           foreach  ($registroshijos as $row) {

					      if($row->numeroreservas == 0){
							  $row->setScenario('Atencionreserva');
							  $modeloreserva=New Alreserva;
							  $modeloreserva->hidesolpe=$row->id;
							  $modeloreserva->estadoreserva=ESTADO_RESERVA_CREADO;
							  $modeloreserva->fechares=date("Y-m-d H:i:s");
							  $modeloreserva->usuario=Yii::app()->user->Name;
							  $modeloreserva->codocu='450';
							  $modeloreserva1=New Alreserva;
							  $modeloreserva1->hidesolpe=$row->id;
							  $modeloreserva1->estadoreserva='10';
							  $modeloreserva1->fechares=date("Y-m-d H:i:s");
							  $modeloreserva1->usuario=Yii::app()->user->Name;
							  $modeloreserva1->codocu='800';

							  $factorconversion=Alconversiones::convierte($row->codart,$row->um);
							  //$cantidadefectiva=($row->um <>$row->maestro->um)?$row->cant*$factorconversion:$row->cant;

							    						if($row->cant*$factorconversion <= $row->desolpe_alinventario->cantlibre ){  ///si hay stock sufieciente no hya probelma
									             				 $modeloreserva->cant= $row->cant;
									               					 $modeloreserva1->cant=0;
									             // $mensa.=" Stock mayor al que se pide ok!  Se reservo en el item ".$row->item."  ".$modeloreserva->cant." <br> ";
								               			 	} else {
															$modeloreserva->cant= $row->desolpe_alinventario->cantlibre/$factorconversion; //solo reservamos lo qu esta en stock
															$modeloreserva1->cant= $row->cant-$row->desolpe_alinventario->cantlibre/$factorconversion; ///la diferencia la solicitiamos
									     //  $mensa.=" Stock menor al que se pide  Se reservo una parte  en el item ".$row->item."  ".$modeloreserva->cant." <br> ";
									     // $mensa.=" Se solicita  una parte  en el item ".$row->item."  ".$modeloreserva1->cant." <br> ";
															}
							             ////Luego actualizamoes el inventario
							             $inventario=$this->devuelveinventario($row->centro,$row->codal,$row->codart);
							  //  echo "<br>"; echo "<br>"; echo "<br>"; echo "<br>"; echo "<br>";
							 // echo $inventario->codcen."   ".$inventario->codalm."    ".$inventario->codart."<br>";

							             $inventario->cantres+=$modeloreserva->cant*$factorconversion;
							             $inventario->cantlibre-=$modeloreserva->cant*$factorconversion;
							             $inventario->setScenario('modificacantidad');
										$row->est='60';
							         if($modeloreserva->cant > 0)
							         if(!$modeloreserva->save())
								      $mensa.=" No se pudo generar el registro de  reserva para el item ".$row->item." -- ".$row->txtmaterial." <br>";
							         if($modeloreserva1->cant > 0)
							         if(!$modeloreserva1->save())
								      $mensa.=" No se pudo generar el registro de  reserva para el item ".$row->item." -- ".$row->txtmaterial." <br>";
							        if(!$row->save())
								    $mensa.=" No se pudo actualizar el estado del detalle del item ".$row->item." -- ".$row->txtmaterial." <br>";
							       if(!$inventario->save())
								      $mensa.=" No se pudo actualizar el registro de inventario del  item ".$row->item." -- ".$row->txtmaterial." <br>";

						  }

				   }//fin del For
			if(strlen($mensa)==0)  { //Si s epudo actualziar
									$transaccion->commit();
									Yii::app()->user->setFlash('success', "Se hizo la reserva automatica del Documento ".$mensa);
										$this->render('update',array('model'=>$model));
										yii::app()->end();
							}     else   {
								$transaccion->rollback();
									Yii::app()->user->setFlash('error', "No se pudo reservar automaticamente el documento, hay  errores  :".$mensa);
									$model->refresh();
									$this->render('update',array('model'=>$model));
							//$model->refresh();
								}
		  }  else {  ///eN CASO DE SER UNA SOLOE DE COMNPRAS NO EFECTUAR NADA PERO AVISAR
			Yii::app()->user->setFlash('error', "No se pueden reservar, items de  solicitudes para aprovisionamiento ".$mensa);
			$this->render('update',array('model'=>$model));
			yii::app()->end();
		 }
	}

 public function actionAtiendesolpe() {
         $model=new VwReservasPendientes('search_por_pendiente');
         $model->unsetAttributes();  // clear any default values
         if(isset($_GET['VwReservasPendientes']))
             $model->attributes=$_GET['VwReservasPendientes'];

         $this->render('adminsolpe',array(
             'model'=>$model,
         ));
 }


    public function actionlimpiarcarro() {

        if(isset( $_SESSION['350']))
            $_SESSION['350']=array();


        echo CHtml::link(CHtml::image(Yii::app()->getTheme()->baseUrl.'/img/maletin.png',"",array('width'=>'20','height'=>'20')),'#','')."    -  Mi maletin(".count($_SESSION['350']).")";

    }



    public function actionponeralcarro() {
        $autoIdAll = $_POST['cajita'];
        if(!isset( $_SESSION['350']))
            $_SESSION['350']=array();

        if(count($autoIdAll)>0 )
        {

            foreach($autoIdAll as $autoId)
            {
                if (!in_array($autoId, $_SESSION['350'], true))
                array_push(  $_SESSION['350'],$autoId);
               // print_r(Yii::app()->session['carrito']);

            }
        }
		Yii::app()->session['DOC350']= $_SESSION['350'];
           // echo CHtml::link(CHtml::image(Yii::app()->getTheme()->baseUrl.'/img/maletin.png',"",array('width'=>'20','height'=>'20')),'#','')."    -  Mi maletin(".count($_SESSION['350']).")";
          print_r(Yii::app()->session['DOC350']);
    }

    public function actionmuestra() {
		ECHO "LA SESION ES ".Yii::app()->session['idsolpe'] ;

    }


    public function actionSolpeautomatica($id) {
    /***primero creamos la varibale sesion si no esta creadqa     */
		//veriifcamos UN CHISTOSO NO PASE CUALQUIER  ID POR LA UR
		$mensaje="";
		      $alreserva=Alreserva::Model()->findByPk($id);
	if(!is_null($alreserva)) {
		if (  ( $alreserva->estadoreserva == '10' ) )
		{
			if ( ! isset( Yii::app ()->session[ 'idsolpe' ] ) )  //Si no existe la sesion
			{
				//creando una solpe NUEVA
				$solpe = New Solpe;
				$solpe->escompra = '1';
				$solpe->textocabecera = "Documento automático";
				//$solpe->estado='01';
				$solpe->save ();
				$solpe->refresh ();
				Yii::app ()->session[ 'idsolpe' ] = $solpe->id;
				///para que agarre el estado '01'
				$solpe->textocabecera = 'Item automatico.,,,,,';
				$solpe->save ();
				/////
				$identidad = $solpe->id;

			} else {

				//sI YA XISTE LA SOLPE HAYA QUER VERIFICAR SU ESTADO
				//SI ESTA CREADO AGREGAR, SI YA ESTA APROBADO O ANULADO, ES MEJOR CREAR OTRA
				$solpe = Solpe::model ()->findByPk ( Yii::app ()->session[ 'idsolpe' ] );
				if ( ! is_null ( $solpe ) )
				{
					// $solpe->textocabecera='Item automatico';
					if ( ! ( $solpe->estado == '10' ) )
					{
						//SI ESTA CREADO AGREGAR ITEMS A ESTA SOLPE, SI YA ESTA APROBADO O ANULADO, ES MEJOR CREAR UAN NUEVA SOLPE
						$solpe2 = New Solpe;
						//$solpe2->estado='01';
						$solpe2->textocabecera = 'Item automaticosolpes';
						$solpe2->save ();
						$solpe2->refresh ();
						$solpe3 = Solpe::model ()->findByPk ( $solpe2->id );
						$solpe3->setScenario ( 'automatica' );
						$solpe3->escompra = '1';
						if ( $solpe3->save () )
							//echo "graba ";
						unset( Yii::app ()->session[ 'idsolpe' ] );
						Yii::app ()->session[ 'idsolpe' ] = $solpe2->id;
						$identidad = $solpe2->id;
						//echo "NUEVA SOLPE ".$solpe2->numero." ----".$solpe2->id."  ";
						//Yii::app()->end();
					} else {

						$identidad = $solpe->id;
					}
				} ELSE {
					/*ECHO "ERROR COMPARITO LA SOLPE " . Yii::app ()->session[ 'idsolpe' ] . "  NO EXISTE";
					Yii::app ()->end ();*/
					$mensaje.=" ERROR : LA SOLPE " . Yii::app ()->session[ 'idsolpe' ] . "  NO EXISTE <br>";
				}


				$alreserva->estadoreserva='20';
				$alreserva->save();
				$detalle = Desolpe::Model ()->findByPk ( $alreserva->hidesolpe );


				$detallesolpe = new Desolpe;
				$detallesolpe->setscenario ( 'insert' );

				$detallesolpe->hidsolpe = $identidad; ////IMPORTANTE , DEBE COGER LA SOLPE QUE NO ESTA APROBADA
				$detallesolpe->tipimputacion = $detalle->tipimputacion;
				$detallesolpe->centro = $detalle->centro;
				$detallesolpe->codal = $detalle->codal;
				$detallesolpe->txtmaterial = $detalle->txtmaterial;
				$detallesolpe->textodetalle = $detalle->textodetalle;
				// $detallesolpe->txtmaterial=$detalle->txtmaterial;
				$detallesolpe->fechacrea = $detalle->fechacrea;
				$detallesolpe->fechaent = $detalle->fechaent;
				$detallesolpe->fechalib = $detalle->fechalib;
				$detallesolpe->imputacion = $detalle->imputacion;
				$detallesolpe->estadolib = $detalle->estadolib;

				$detallesolpe->solicitanet = $detalle->solicitanet;
				$detallesolpe->est = '10';  ///esto es clave , solo se pueden garegar detalles que se van a aa parobar
				//es decir nos e puede insertar un detalle en una solpe APROBADA

				$detallesolpe->um = $detalle->um;
				$detallesolpe->tipsolpe = $detalle->tipsolpe;
				$detallesolpe->cant = $alreserva->cant; ///iMPORTANTE, AQUIE ES LA CANTOIDAD DE LA RESERVA
				$detallesolpe->codart = $detalle->codart;
				$detallesolpe->idreserva = $id;
				$detallesolpe->save ();
				$mensaje.="OK: Se genero la solicitud de compra ".$detallesolpe->desolpe_solpe->numero."  item ".$detallesolpe->item."  con exito <br>";


			}

	      }else{ // En caso de que la reserva tengia un status inadecuado
			$mensaje.="La reserva ".$alreserva->id."  no tiene el status adecuado ".$alreserva->estadoreserva."<br>";
		}

		  } ///en caso haya sido cualquier id
		  ELSE   {
			  $mensaje.="El parametro pasado no corresponde a ningun  documento Reserva<br>";

		  }
  echo  $mensaje;
	}

	public function actiondetienereserva(){
		$id=$_POST['VwReservasPendientes']['idreserva'];
		$id=(int)MiFactoria::cleanInput($id);
		$registro=Alreserva::model()->findByPK($id);

		$registro->estadoreserva=ESTADO_RESERVA_CERRADO;
		$registro->setScenario('cambiaestado');
		$registro->save();
		echo "<div class='flash-success'>Se cerro la reserva</div>";
	}


/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionImprimir($id)
	{
	
	 /* $mPDF1=Yii::app()->ePdf->mpdf();
	    $mPDF1->WriteHTML($this->render('view',array(
			'model'=>$this->loadModel($id),
		),true) );
		
	      $mPDF1->output();	*/
	      $solpe=Solpe::model()->findByPk($id);
	      $detalle=Desolpe::Model()->findall("hidsolpe='".$id."'");
	      //$listacampos=VwGuia::Model()->attributeNames();
	      if ($solpe) {
	      $listacampos=array(
	      					 // 'razondestinatario'=>array('left'=>100,'top'=>300),
	      					  'numero'=>array('left'=>600,'bottom'=>1000),
	      					  'fechadoc'=>array('left'=>600,'bottom'=>980),
	      					  'textocabecera'=>array('left'=>145,'bottom'=>980),
	      					 // 'dptopartida'=>array('left'=>285,'bottom'=>980),
	      					  

	      					);
	      							$cadena="<style>";
	    									 foreach ($listacampos  as $clave=>$valor){
	     												$cadena=$cadena.'  .'.$clave.' {position: absolute; overflow: visible; 													left: 100; 
															left: '.$listacampos[$clave]["left"].';
														 	bottom: '.$listacampos[$clave]["bottom"].'; 
																padding: 0em; font-family:sans; font-size:0.6em; margin: 0;
																		
															}';
											 	 				}

						
						//matriz para guardar las absisas de los items
								$absisas=array(
												'item'=>array('ancho'=>50,'absi'=>27),
												'cant'=>array('ancho'=>30,'absi'=>115),
												'codart'=>array('ancho'=>60,'absi'=>200),
												'txtmaterial'=>array('ancho'=>250,'absi'=>400),
												
									);

								//el valor de las coordemadas donde empieza a pintar la tabla
								//$x_inicio=69;
								$y_inicio=600;
								//el valor del alto de la fila
								$altofila=15;

						//generando los estilos  de el detalle
								//$cadena2="";
								$subrayado=" ";
								
						for ($i=0; $i < count($detalle); $i++) { //recorriendo la cantidad de filas que hay
									       foreach($absisas as $clave=>$valor)  {
									       		if($i==count($detalle)-1)
									       			$subrayado=" border-bottom: 1px solid #000; ";

									       		$cadena=$cadena.'     .'.$clave.$i.'{position: absolute;  '.$subrayado.' overflow: visible; width:'.$absisas[$clave]["ancho"].'; left: '.$absisas[$clave]["absi"].';bottom: '.($y_inicio-($i+1)*$altofila).'; padding: 0em; font-family:sans; font-size:0.7em; margin: 0;} ';

									      /* $cadena2=$cadena2.'     .'.$clave.$i.'{position: absolute; overflow: visible; 
									       		left: '.$absisas[$clave].';
									       		bottom: '.$y_inicio+($i+1)*$altofila.'; }';*/


									        	}
								}


						$cadena = $cadena.'</style><body>';
 					

							//generando los divs  del encabezado
 							foreach ($listacampos  as $clave=>$valor){
	     											$cadena=$cadena.'<div class="'.$clave.'" >'.$solpe[$clave].'</div>';
								}


								//generando los divs  de el detalle
								for ($i=0; $i < count($detalle); $i++) { //recorriendo la cantidad de filas que hay
									     
									      foreach($absisas as $clave=>$valor) {
									       $cadena=$cadena.'<div class="'.$clave.$i.'">'.$detalle[$i][$clave].'</div>';

									                                            }
									        	
								}



								$cadena=$cadena.'<div class="nino">'.count($detalle).'</div>';

								
								//$cadena=$cadena.$this->renderpartial('vw_detalle_solpe',array('modelcabecera'=>$solpe,'eseditable'=>$this->eseditable($solpe->estado)));  
				

								//echo $cadena;




				$mpdf=Yii::app()->ePdf->mpdf();
				$mpdf->SetDisplayMode('fullpage');				
				$mpdf->WriteHTML($cadena);
				$mpdf->Output();
				exit;
			} else {

				throw new CHttpException(404,'El enlace o direccion solicitado no existe');
			}

	}

public function actionperu(){
	echo "Yii::app()->baseUrl :".Yii::app()->baseUrl."<br>";
	echo "Yii::getPathOfAlias('webroot') :".Yii::getPathOfAlias('webroot')."<br>";
	echo "Yii::getPathOfAlias('ext') :".Yii::getPathOfAlias('ext')."<br>";
	echo "Yii::getPathOfAlias('system') :".Yii::getPathOfAlias('system')."<br>";
	echo "Yii::getPathOfAlias('zii') :".Yii::getPathOfAlias('zii')."<br>";
	echo "Yii::getPathOfAlias('application') :".Yii::getPathOfAlias('application')."<br>";
	echo "Yii::getPathOfAlias('webroot.images') :".Yii::getPathOfAlias('webroot.images')."<br>";
	echo "Yii::app()->theme->baseUrl  :".Yii::app()->theme->baseUrl ."<br>";
	//Yii::app()->theme->baseUrl
	echo "----------****usando la clase CFILE  :******--------"."<br>";
	$yourfile = Yii::getPathOfAlias('webroot').'/soli.php';
	ECHO "ARCHIVO DE EJEMPLO  $ yourfile :".$yourfile."<br>";
// Call extension into $cfile variable
	ECHO "Asignando el obejto a  la variable $ cfile : $ cfile = Yii::app()->file;"."<br>";
	$cfile = Yii::app()->file;
// Check file exist
	ECHO "verifica si existe el archivo $ cfile->set($ yourfile)->existe  :  "."<BR>";
	IF($cfile->set($yourfile)->exists)
	{
// Create file
	ECHO "Crea la insrtancia  $ cfile->set($ yourfile)->create();  :  ".$cfile->set($yourfile)->create()."<br>";
	$cfile->set($yourfile)->create();
// Append Content
	//$cfile->set($yourfile)->setContents('treat me a coffee for this tutorial!');
  echo " el rela path     ".$cfile->getPermissions();
// Get Content from file
	//$cfile->set($yourfile)->getContents();


// Delete File
	//$cfile->set($yourfile)->delete();

	} ELSE {
		ECHO "NO EXISTE EL ARCHIVO ".$yourfile ;
	}

	if(file_exists(Yii::getPathOfAlias('webroot').'/materiales/18000001.JPG')){
		echo CHtml::image(Yii::app()->baseUrl.'/materiales/18000001.JPG');
	} ELSE {
		ECHO "NO EXISTE ".Yii::getPathOfAlias('webroot').'/materiales/18000001.JPG';
	}
	//echo Yii::getPathOfAlias('webroot');
	Yii::app()->end();
	$modelito=Solpe::model()->findByPk(75);
			$matrizdetalle=$modelito->solpe_desolpe;
				for ($i=0; $i < count($matrizdetalle); $i++) { 
								$modelodesolpe=Desolpe::model()->findByPk($matrizdetalle[$i]['id']);
								//creamos el registro Kardex 
								$modelokardex= new Alkardex;
								//Colocamos los valores 
								$modelokardex->codart=trim($modelodesolpe->codart); //el codigo material
								$modelokardex->cant=$modelodesolpe->cant; //el codigo material
								$modelokardex->codmov='25'; //el codigo MOVIMIENTO
								$modelokardex->alemi='001'; //el almacen emisor
								$modelokardex->aldes='001'; //el almacen emisor
								$modelokardex->fecha=date("Y-m-d H:i:s"); //contable
								$modelokardex->coddoc='001'; //el codigo documento que caisa el mov
								$modelokardex->numdoc='0010303030'; //el numero de doc que causa el mov
								$modelokardex->usuario=Yii::app()->user->name;
								$modelokardex->um=$modelodesolpe->um; //el codigo material
								$modelokardex->codocuref='001'; //el cod del doc vale almacen
								$modelokardex->numdoc='0010303030'; //el numero vale alamcen 
								$modelokardex->codcentro='1504'; //el codigo documento que caisa el mov
								//$modelokardex->codestado='01'; //el estado
								$modelokardex->fechadoc=date("Y-m-d H:i:s"); //fecah del documetno
								$modelokardex->hidvale=40; //fecah del documetno
								$modelokardex->idref=$modelodesolpe->id; //fecah del documetno
		  					if($modelodesolpe->numeroreservas > 0) { ///solo las que tienen reservas valen 

		  									$modelokardex->check='1'; //es valido

		 										 } else {
		 										 	$modelokardex->check='0'; //no es valido

		 										 }

		 										 $modelokardex->save();
									}
				


}

public function actionImprimir2($id) {

	$this->layout = '//layouts/iframe';
$solpe=Solpe::model()->findByPk($id);
 $detalle=Desolpe::Model()->findall("hidsolpe='".$id."' and est <> '20'  order by item asc");
//$cadena=$this->renderpartial('impresion',array(
			//'solpe'=>$solpe,
		//));

 $cadena='<div class="titulo"> <h1>SOLICITUD - '.$solpe->numero.'</h1>  </div>';
 $cadena=$cadena.'<div class="textocabecera">'.$solpe->textocabecera.'</div>';
    $cadena=$cadena.'<div class="fecha"> Fecha : '.$solpe->fechadoc.'</div>';
     $cadena=$cadena.'<div class="usuario">Usuario : '.$solpe->creadopor.'</div>';
     //$cadena=$cadena.'<div class="ceco"> Imputacion : '.$solpe->creadopor.'</div>'; 
    $cadena=$cadena.'<div class="detalle">';
$cadena=$cadena.'<div id="content">';
    $cadena=$cadena.'<table cellspacing="0">';
    $cadena=$cadena.'<tbody>';
           $cadena=$cadena.' <tr class="odd-row">';
      $cadena=$cadena.'<th class="first">Item</th>';
                    $cadena=$cadena.'<th>Cant.</th>';
                     $cadena=$cadena.'<th>Um</th>';
                     $cadena=$cadena.'<th>Codigo</th>';
                     $cadena=$cadena.'<th>Descripcion</th>';
                     $cadena=$cadena.'<th>Fecha Ent</th>';
                     $cadena=$cadena.'<th>Fecha creac</th>';
                 
                    $cadena=$cadena.'<th>Centro</th>';
                    $cadena=$cadena.'<th class="last">Almac</th>';
            $cadena=$cadena.' </tr>';

for ($i=0; $i < count($detalle); $i++) { 
	                     $cadena=$cadena.'<tr>';
	                     $cadena=$cadena.'<td class="first"> ';
	                      $cadena=$cadena.$detalle[$i]["item"];
	                       $cadena=$cadena.'</td>';
	                         $cadena=$cadena.'<td > ';
	                      $cadena=$cadena.$detalle[$i]["cant"];
	                       $cadena=$cadena.'</td>';
	                        $cadena=$cadena.'<td > ';
	                      $cadena=$cadena.$detalle[$i]["um"];
	                       $cadena=$cadena.'</td>';
	                        $cadena=$cadena.'<td > ';
	                      $cadena=$cadena.$detalle[$i]["codart"];
	                       $cadena=$cadena.'</td>';
	                        $cadena=$cadena.'<td > ';
	                      $cadena=$cadena.$detalle[$i]["txtmaterial"];
	                       $cadena=$cadena.'</td>';
	                        $cadena=$cadena.'<td > ';
	                      $cadena=$cadena.$detalle[$i]["fechaent"];
	                       $cadena=$cadena.'</td>';
	                       $cadena=$cadena.'<td > ';
	                      $cadena=$cadena.$detalle[$i]["fechacrea"];
	                       $cadena=$cadena.'</td>';
	                        $cadena=$cadena.'<td > ';
	                      $cadena=$cadena.$detalle[$i]["centro"];
	                       $cadena=$cadena.'</td>';
	                        $cadena=$cadena.'<td class="last"> ';
	                      $cadena=$cadena.$detalle[$i]["codal"];
	                       $cadena=$cadena.'</td>';
	                           $cadena=$cadena.'</tr>';
									      }
      $cadena=$cadena.' </tbody>';
   $cadena=$cadena.'</table>';

 $cadena=$cadena.'</div>';

 $cadena=$cadena.'</DIV> ';

 $cadena=$cadena.'<div class="firmas">';
  $cadena=$cadena.' <div class="firma1"> </div>';
   $cadena=$cadena.'<div class="firma2"> </div>';

 $cadena=$cadena.'</div>';



$mpdf=Yii::app()->ePdf->mpdf();
			$hojaestilo=file_get_contents('themes/abound/css'.DIRECTORY_SEPARATOR.'estilosolpe.css');
				$mpdf->SetDisplayMode('fullpage');				
				$mpdf->WriteHTML($hojaestilo,1);
				$mpdf->WriteHTML($cadena,2);
				$mpdf->Output();
				exit;


}




public function actionstock() {



	//$codiguito='14000008';
	//echo gettype($_POST['codiguito']);
	if (isset($_POST['codiguito'])) {
           $codigox=$_POST['codiguito'];
           $centro=$_POST['centrito'];
        $almacen=$_POST['almacencito'];

			echo $this->renderpartial("stocks",array('codigo'=>$codigox,'centro'=>$centro,'codal'=>$almacen),true);
								}



		

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
		$model=new Solpe;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Solpe']))
		{
			$model->attributes=$_POST['Solpe'];
			if($model->save()){
				$this->redirect(array('update','id'=>$model->id));
				$this->refresh();
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
		//$this->layout='//layouts/prueba_layout';
		$ahora=time();
		$model=$this->loadModel($id);
		if($model->estado==ESTADO_PREVIO and ($ahora-strtotime($model->fechadoc.'')>24*60*60))
		{
			$model->delete();
			$this->redirect(array('admin'));
		}


		if(isset($_POST['Solpe']))
		{
             $prefix="public_";
			/*print_r($_POST['Solpe']);
			echo $model->getScenario();
			yii::app()->end();*/
			$model->attributes=$_POST['Solpe'];
			if($model->save()) {
				//anexamos los items agregados 
				$command = Yii::app()->db->createCommand(" update ".$prefix."desolpe1 set est='10' where est='99' AND hidsolpe=".$id."    ");
				 $command->execute();
				 $command2 = Yii::app()->db->createCommand(" update ".$prefix."desolpe1 set firme='1' where hidsolpe=".$id."  ");
				 $command2->execute();
				Yii::app()->user->setFlash('success', "La solicitud se ha grabado!");
				$this->redirect(array('update','id'=>$model->id));
				//$this->redirect(array('view','id'=>$model->id));
			                }
		}


		$this->render('update', array('model'=>$model));
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionVerificadispo($idcabeza)
	{
		

		$this->layout = '//layouts/iframe';

		$this->render('disponibilidad',array(
			'idcabeza'=>$idcabeza,
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
		$dataProvider=new CActiveDataProvider('Solpe');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}


	public function actioncargadetalle()

	{
		$filtro=MiFactoria::cleanInput((int)$_GET['identi']);
		$this->layout = '//layouts/iframe';
		//echo "holitas".$_GET['identi'];
		$modelodetalle=Desolpe::model()->findByPk($filtro);

		if (is_null($modelodetalle)){
			echo "No se encontraron registros ";
		}else{
			//si se trata de una solpe directa sin reservas (SOLPE PARA ABASTECIMIENTO, SIN IMPTACION)
			if( $modelodetalle->numeroreservas==0){
				echo $this->renderpartial("tab_solpecompras",array('modelodetalle'=>$modelodetalle, "idcabeza"=>$modelodetalle->id), true);

			}else {
				echo $this->renderpartial("tab_reservas",array('modelodetalle'=>$modelodetalle, "idcabeza"=>$modelodetalle->id), true);

			}

		}
		//$modelodetalle=Desolpe::model()->findByPk(99+0);
		//echo "hiolas as as ";
		//	echo "Wsfsf mjspfsgsgsgsgs gsgsg";
				}

	public function actionCargafavorito($id)

	{
		$id=(int)MiFactoria::cleanInput($id);
		$modelodetalle=new Desolpe();
		$modelodetalle->valorespordefecto();
		$modelocabeza=Solpe::model()->findbypk($id);
		if(is_null($modelocabeza))
			throw new CHttpException(500,'No existe esta solicitud con este ID');
		if($this->eseditable($modelocabeza->estado)) {
        if(isset($_POST['Desolpe']))
		    {

				$modelodetalle->attributes=$_POST['Desolpe'];

				/*$criterio=New CDbcriteria;
				$criterio->addcondition("hidsolpe=:vhidsolpe");
				$criterio->params=Array(":vhidsolpe"=>$modelodetalle->idenfavorito);
				*/
				$listafavoritos=Listamateriales::model()->findByPk($modelodetalle->idenfavorito)->hijos;
              // echo " esto es ".count($listafavoritos);
				//yii::app()->end();
				foreach ($listafavoritos as $fila){
					      // if($fila['est'] <> '02' and $fila['est'] <> '99' ) //SIEMPRE QUE SEA UN ESTADO VALIDO
						  // {
								 $registro=New Desolpe();
					             $registro->setScenario('insert');
								 $registro->attributes=$modelodetalle->attributes;
					             $registro->codart=$fila->codigo;
								$registro->um=$fila->um;

								$registro->txtmaterial=$fila->maestro->descripcion;
								$registro->cant=$fila->cant;
					 			//$registro->tipsolpe='M';
					           $registro->hidsolpe=$modelocabeza->id;
								$registro->codocu='350';
							  if( $registro->save()){
								  Yii::app()->user->setFlash('success', " Se Agrego la lista '".$registro->codart."' a la solicitud ");

							  } else {
								 // echo " NO grabo  \n";
								 // print_r($registro->attributes);
							  }

						 //  }

									}


					//Close the dialog, reset the iframe and update the grid
								echo CHtml::script("window.parent.$('#cru-dialogdetalle').dialog('close');
									window.parent.$('#cru-detalle').attr('src','');
									window.parent.$.fn.yiiGridView.update('detalle-grid');
																		");
					Yii::app()->user->setFlash('success', " Se Agrego la lista  a la solicitud ");
					$this->render('update',array(
						'model'=>$modelocabeza, 'idcabeza'=>$modelocabeza->id
					));
					Yii::app()->end();



		}

		// if (!empty($_GET['asDialog']))
		$this->layout = '//layouts/iframe';
		$this->render('_form_cargafavorito',array(
			'model'=>$modelodetalle,
		));
		} else {
			throw new CHttpException(500,'No se puede agregar mas items a esta solpe');
		}


	}


	public function actionCreafavorito($id)

	{
		//$modfav=new Documentosfavoritos();
		$modelocabeza=Solpe::model()->findbypk($id);
		if(is_null($modelocabeza))
			throw new CHttpException(500,'No existe esta solicitud con este ID');

			$modfav=new Listamateriales();
			//$model->valorespordefecto();
			// Uncomment the following line if AJAX validation is needed
			//$this->performAjaxValidation1($model);

			if(isset($_POST['Listamateriales']))
			{
				$modfav->attributes=$_POST['Listamateriales'];
				//$modfav->codocu='340';
				//$modfav->hidocu=$modelocabeza->id;
				$modfav->iduser= Yii::app()->user->id;
				//$modfav->hidocu=$modeloreferancia->id;
				if($modfav->save()) {
					//agregabdo los detalles
					$hijos=$modelocabeza->solpe_desolpe;
					$modfav->refresh();
					foreach($hijos as $fila){
						$regi=new Dlistamaeriales();
						$regi->setAttributes(
							array(
								'hidlista'=>$modfav->id,
						         'codigo'=>$fila->codart,
							),false
						);
						$regi->save();
					}

					if ( ! empty( $_GET[ 'asDialog' ] ) ) {
						//Close the dialog, reset the iframe and update the grid
						echo CHtml::script ( "window.parent.$('#cru-dialogfavorito').dialog('close');
													                    window.parent.$('#cru-detallefav').attr('src','');

																		" );
						Yii::app ()->user->setFlash ( 'success' , " Se Agrego la lista '" . $modfav->nombrelista . "' a Sus Favoritos " );
						$this->render ( 'update' , array (
							'model' => $modelocabeza , 'idcabeza' => $modelocabeza->id
						) );
						Yii::app ()->end ();
					}

				}

			}

			// if (!empty($_GET['asDialog']))
			$this->layout = '//layouts/iframe';
			$this->render('_form_favorito',array(
				'model'=>$modfav, 'idcabeza'=>$idcabeza
			));

	}




	/****************************************************
	 *  muestra la vista de configuracion de los eventos
	 *+++++++++++++++++++++++++++++++++++++++++++++++++*/	
	
	public function actionConfiguraop()
	{
			$docu='340';  //guia de remision
			$docuhijo='350'; //detalle guia de remisio


        $matrizpadre=Opcionescamposdocu::Model()->findAll(" codocu=:cod",array(":cod"=>$docu));
        for ($i=0; $i < count($matrizpadre); $i++){
            $cantidadregistros=Yii::app()->db->createCommand("SELECT id FROM  ".Yii::app()->params['prefijo']."opcionesdocumentos WHERE IDOPDOC=".$matrizpadre[$i]['id']."")->QueryScalar();
           If (!$cantidadregistros) {
            $command = Yii::app()->db->createCommand("INSERT INTO ".Yii::app()->params['prefijo']."opcionesdocumentos (IDUSUARIO,IDOPDOC,valor) VALUES (".Yii::app()->user->id.",".$matrizpadre[$i]['id'].",'') ");
            $command->execute();
           }
        }

        $matrizpadre1=Opcionescamposdocu::Model()->findAll(" codocu=:cod",array(":cod"=>$docuhijo));
        for ($i=0; $i < count($matrizpadre1); $i++){
            $cantidadregistros=Yii::app()->db->createCommand("SELECT id FROM  ".Yii::app()->params['prefijo']."opcionesdocumentos WHERE IDOPDOC=".$matrizpadre1[$i]['id']."")->QueryScalar();
            If (!$cantidadregistros) {
                $command = Yii::app()->db->createCommand("INSERT INTO ".Yii::app()->params['prefijo']."opcionesdocumentos (IDUSUARIO,IDOPDOC,valor) VALUES (".Yii::app()->user->id.",".$matrizpadre1[$i]['id'].",'') ");
                $command->execute();
            }
        }
				 
				 $proveedor=VwOpcionesdocumentos::model()->search_us($docu,Yii::app()->user->id);
				  $proveedor1=VwOpcionesdocumentos::model()->search_us($docuhijo,Yii::app()->user->id);
				 $this->render('vw_admin_opciones',array(
							'proveedor'=>$proveedor,
							'proveedor1'=>$proveedor1, 
							));
	    
			
	}

public function actionTomarcompras(){
    $model=new VwSolpe('search');
    $model->unsetAttributes();  // clear any default values
    if(isset($_GET['VwSolpe']))
        $model->attributes=$_GET['VwSolpe'];

    if ($this->isExportRequest()) { //<==== [[ADD THIS BLOCK BEFORE RENDER]]
        //set_time_limit(0); //Uncomment to export lage datasets
        //Add to the csv a single line of text
        //  $this->exportCSV(array('POSTS WITH FILTER:'), null, false);
        //Add to the csv a single model data with 3 empty rows after the data
        // $this->exportCSV($model, array_keys($model->attributeLabels()), false, 3);
        //Add to the csv a lot of models from a CDataProvider

        $this->exportCSV($model->search_compras(), array('numsolpe','item','cant','desum','codart','txtmaterial','fechacrea','fechaent','codal','centro','usuario','est'));
    }

    $this->render('tomarsolpe',array(
        'model'=>$model,
    ));

}

public function actiontratareserva($id){
	$filtro=(int)MiFactoria::cleanInput($id);
	$model=VwReservasPendientes::model()->find("iddesolpe=".$filtro);
	$this->layout = '//layouts/iframe';
	//yii::app()->user->setFlash('notice','Esta reserva ya tiene atenciones, solo puede detener el flujo');
	if(is_null($model))
		throw new CHttpException(404,'No se encontro el registro de la reserva.');

	if (isset($_POST['VwReservasPendientes'])){
		                  echo CHtml::script("window.parent.$('#cru-dialogdetalle').dialog('close');
									window.parent.$('#cru-detalle').attr('src','');
									window.parent.$.fn.yiiGridView.update('solpe-gridex');");
		                             Yii::app()->end();


			}





	$this->render('_form_reserva',array('model'=>$model));
}




public function actionBorraitems()
	{
	
  
		$autoIdAll = $_POST['cajita'];
		$estado=$_POST['Solpe']['estado'];
		 if(count($autoIdAll)>0 )
			 {
			 	$modelin=$this->loadmodel($_POST['Solpe']['id']);
		         $transaccion=$modelin->dbConnection->beginTransaction();

				 foreach($autoIdAll as $autoId)
					{
							$this->borraitem($autoId);
					 }
				//muy bien , ahora que pasa si anulando este(os) items, el documento padre queda sin mas items validos?
			// ..pues tiene que anularse tambien
				  $consulta=Yii::app()->db->createCommand("select count(*) from ".Yii::app()->params['prefijo']."desolpe1 where est <> '20' and hidsolpe=".$_POST['Solpe']['id']." ")->queryScalar();
				if(!$consulta) ///si todos estan anulados 
				   if($consulta==0 and $modelin->estado <> '99' ) {//si es cero
				   			$command = Yii::app()->db->createCommand("update ".Yii::app()->params['prefijo']."solpe set estado='30'  where id =".$_POST['Solpe']['id']." ");
				 			$command->execute();
					   Yii::app()->user->setFlash('succcess', "Se actualizo tambien la cabecera del documento");

				   }
				 $transaccion->commit();
				 //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array(index));

				// Yii::app()->end();
			} ///luego actualizar yodos los cambos

	}


	
public function borraitem($autoId) //Borra un registro de solpe
	//para borrar  un registro tenemso 	ue tener en cuenta los criterios siguiertentes:
	//  1) No debe de haber reservas activas, esto se logra contandolas con la propiedad "numerodereservas" del objeto modelo
	{




		$modelito=Desolpe::model()->findByPk($autoId);
		if($modelito->desolpe_solpe->iduser==yii::app()->user->id){

			if($modelito->desolpe_solpe->estado=='99') {
				$command = Yii::app()->db->createCommand("delete from   ".Yii::app()->params['prefijo']."desolpe1   where id =".$autoId."   ");
				$command->execute();
				Yii::app()->user->setFlash('succcess', "El registro de solicitud ".$modelito->desolpe_solpe->numero."-".$modelito->item. " se ha borrado");
			} else {
				$modelito->setscenario('Atencionreserva');
				if($modelito->numeroreservas==0 ){
					if($modelito->est=='20'){ //si ya estaba nulado
						Yii::app()->user->setFlash('error', "El registro de solicitud ".$modelito->desolpe_solpe->numero."-".$modelito->item. "Ya fue anulado");
					} else {
						$modelito->est='20';
						$modelito->save();
						Yii::app()->user->setFlash('succcess', "El registro de solicitud ".$modelito->desolpe_solpe->numero."-".$modelito->item. " se ha anulado sin problemas");
					}
				} else {
					Yii::app()->user->setFlash('error', "El registro de solicitud ".$modelito->desolpe_solpe->numero."-".$modelito->item. " No puede ser anulado  por que presenta reservas activas");
				}
			}

		} else {
			Yii::app()->user->setFlash('error', "El registro de solicitud ".$modelito->desolpe_solpe->numero."-".$modelito->item. " No puede ser anulado  por que es de otro usuario ");

		}



		foreach(Yii::app()->user->getFlashes() as $key => $message) {
			echo "*)". $message . "\n";		}
		//echo $this->renderpartial("vw_mensajes",array());
	}

	public function actionPintamensajes() //Para presentar los mensajes de cualquier operacion
		//COnsulta las funciones FLASH();
	{
		 $this->renderpartial("vw_mensajes",array());
	}




	 ///esta funcion se repite para todas las acciones de procesar la guia
	public function verificaestado($id,$idevento){

						//sacando el estado de la guia,si no necuentra datos genera error
		        $modelosolpe=$this->loadmodel($id);
		        $estado=$modelosolpe->estado;
		        $evento=Eventos::model()->findByPk($idevento);
		          if($evento->estadoinicial==$estado ) { //si el estado es el adecuado 
		          				return $evento->estadofinal; //devolver el nuevo estado ya que es valido 

		          }else {
		          			return null; //en caso de no proceder devolver null 

		          }

	          }


   //Idevento=60
	public function actionAprobarSolpe($id){
		         $sepuedeono=$this->verificaestado($id,60); //obteniendo el estado destino
		         							 	$modelin=$this->loadmodel($id);
		         							 	$transaccion=$modelin->dbConnection->beginTransaction();
		         							 if (!$sepuedeono==null) {
		         							 		//verificar primero si los detalles estan preparados 
		         							 	/// si no hya detalle no tiene sentido
		         							 		$items=Desolpe::model()->findall(" hidsolpe=:idcabeza and est in ('99','10')", array(":idcabeza"=>$modelin->id));
		         							 	    if (count($items)> 0) {
		         							 	    			$command = Yii::app()->db->createCommand(" update ".Yii::app()->params['prefijo']."desolpe1 set est='30' where est in ('99', '10') and hidsolpe=".$modelin->id);
															    //$command->execute();
		         							 	$modelin->estado=$sepuedeono;//colocar el estadodestino
		         							 	if ($modelin->save() and $command->execute() >0 ) {
		         							 		$transaccion->commit();
													Yii::app()->user->setFlash('success', "La solicitud se ha Aprobado!");
		         							 		//$this->render("vw_procesado");
		         							 			} else {
													         $transaccion->rollback();
													      Yii::app()->user->setFlash('error', "No se pudop aprobar este documento");
		         							 				//throw new CHttpException(404,'Este documento no se pudo aprobar');
		         							 			}
		         							 	    } else {
														$transaccion->rollback();
														Yii::app()->user->setFlash('error', "No se pudop aprobar este documento, No tiene items validos");
		         							 	    			//throw new CHttpException(404,'Este documento no tiene items validos');
		          								  }
											 }else{
												 $transaccion->rollback();
												 Yii::app()->user->setFlash('error', "No se pudop aprobar este documento, no tiene el estado adecuado");
												// $transaccion->rollback();
		         							 	//throw new CHttpException(404,'Este documento no se puede autorizar, no es una guia o no tiene el estado adecuado');
		          										}

		$this->render('update',array(
			'model'=>$modelin,
		));
										}

  //Idevento=61
	public function actionAnularsolpe($id){
		         $sepuedeono=$this->verificaestado($id,61); //obteniendo el estado destino
		             $modelin=$this->loadmodel($id);
		                $transaccion=$modelin->dbConnection->beginTransaction();
		                  if (!$sepuedeono==null) {
		         							 	$items=Desolpe::model()->findall(" hidsolpe=:idcabeza and est in ('99','10') and est not in ('40','30','50','60') ", array(":idcabeza"=>$modelin->id));
		         							 	    if (count($items)> 0) {
														     //verificamos que la solpe sea una solpe para compras generado por una reserva -Solicitud de compra
																if($modelin->escompra=='1') {
																	 //Regersamos a su estado original todas aquellas reservas solicitudes que estan amarradas a los items de esta Solpe
																	//recordar que los items de estas solpes (Compras) llevan en el campo IDRESERVA el dato del id de la reserva relacionada para amarrar
																	$command5 = Yii::app()->db->createCommand(" update ".Yii::app()->params['prefijo']."alreserva set estadoreserva='10
																	' where
																	id IN ( SELECT idreserva from ".Yii::app()->params['prefijo']."desolpe1 where hidsolpe=".$modelin->id." )" );
																	$command5->execute();
																   }
															$command = Yii::app()->db->createCommand(" update ".Yii::app()->params['prefijo']."desolpe1 set est='20' where hidsolpe=".$modelin->id);
															 $command->execute();
		         							 				$modelin->estado=$sepuedeono;//colocar el estadodestino
		         							 						if ($modelin->save())  { //luego grabar
		         							 		    						 $transaccion->commit();
																				//$transaccion->commit();
																					Yii::app()->user->setFlash('success', "La solicitud se ha Aprobado!");
												               							}
		         							 	    } else {
														$transaccion->rollback();
														Yii::app()->user->setFlash('error', "No se pudop anular este documento, No tiene items validos");
		         							 	    }

		         							 }else{
												 $transaccion->rollback();
												 Yii::app()->user->setFlash('error', "No se pudop anular este documento, No tiene el estado adecuado");


											 }

		$this->render('update',array(
			'model'=>$modelin,
		));
										}
	public function actionvre()
	{
		echo "Numero de reservas ".$registro=Desolpe::model()->findByPk(44)->numeroreservas;
	}


/****************************************************
	 *	Retorna una cadena '' o 'disabled' para deshabilitar los controles del form de la vista
	 *   este es un flag para deshabilitar controles y no recarga Sqls , ES PLANO
	 ****************************************************/
	public function eseditable($estadodelmodelo)
	{
		if ($estadodelmodelo=='10' or $estadodelmodelo=='99' or empty($estadodelmodelo) or is_null($estadodelmodelo)) {return true;} else{return false;}
	}
	

	/****************************************************
	 *	Retorna una BOOEANO  para deshabilitar los controles del form de la vista
	 *   ESTE SI VERIFICA EN  LA BASE DE DATOS
	 ****************************************************/
	public function eseditablecab($estadodelmodelo)

	{
		//$modelin=$this->loadModel($id);
		//$estadodelmodelo=$modelin->estado;

		if ($estadodelmodelo=='10' or $estadodelmodelo=='99' or empty($estadodelmodelo) or is_null($estadodelmodelo)) {return true;} else{return false;}
	}

	

		public function actionModificadetalle($id)
	{
	$model=Desolpe::Model()->findByPk($id);
		 if ($model===null)
		 	 throw new CHttpException(404,'No se encontro ningun documento para estos datos');
	  	$this->performAjaxValidation($model);
		if($model->tipsolpe=='S')
			$model->setScenario('servicios');
      if(isset($_POST['Desolpe']))
		{
			$model->attributes=$_POST['Desolpe'];
			if($model->save())
					  if (!empty($_GET['asDialog']))
												{
													Yii::app()->user->setFlash('success', "..Se agrego el item!");
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialogdetalle').dialog('close');
													                    window.parent.$('#cru-detalle').attr('src','');																		
																		window.parent.$.fn.yiiGridView.update('detalle-grid');
																		");

														Yii::app()->end();
												}
		}
		 if (!empty($_GET['asDialog']))
		$this->layout = '//layouts/iframe';

		if($model->tipsolpe=='M')
			$RENDERIZAR='_detallesolpe';
		if($model->tipsolpe=='S')
			$RENDERIZAR='_form_servicio';


		$this->render($RENDERIZAR,array(
			'model'=>$model, 'idcabeza'=>$model->hidsolpe,
		));
		
	}

public function actioncargapanel(){
	$valor=$_POST['selector_item'];
	$iddetalle=$_POST['id'];
	$model=Desolpe::Model()->findByPk(41);
	//echo  $this->renderPartial('vw_historial', array('model'=>$model,'ide'=>$valor),TRUE);
	echo $this->renderPartial('_detallesolpe',array(
		'model'=>$model, 'idcabeza'=>$model->hidsolpe,
	),true);

}

public function actionprocesarsolpe($id)
	{
		$idevento=$_GET['ev'];
          
			
			 switch ($idevento) {   ///Luego hacer los procedimientos segun sea el caso 
						
						 case 60 : //autorizar guia
							//$this->redirect("Aprobarguia",array("id"=>$id));					
							$this->redirect(array("Aprobarsolpe",'id'=>$id));
							break;
						case 61: // anular guia
							$this->redirect(array("Anularsolpe",'id'=>$id));
							
							break;
						 
						default:
								 throw new CHttpException(404,'No existe este procedimiento para el documento');
	  	
									 }
			
			
			
			
	}
	
   public function actionAnulareserva(){
	   $id=$_POST['VwReservasPendientes']['idreserva'];
	  /* var_dump($_POST['VwReservasPendientes']['idreserva']);
	   yii::app()->end();*/
     $modeloreserva=Alreserva::model()->findByPk($id);
	   if(is_null($modeloreserva))
	   {
		   echo "<div class='flash-error' >No se ha encontrado el registro de la reserva  ".$id."</div>";
		   yii::app()->end();
	   }
     $mensaje=$modeloreserva->anular();
	   if($mensaje==""){
		   echo "<div class='flash-success' >Se anulo la reserva con exito</div>";
	   } else {
		   echo "<div class='flash-error' >".$mensaje."</div>";
		   //echo $mensaje;
	   }



	   /*

       //$identidad=$_post["dato"];
       $model=Alreserva::model()->findByPk($id);
       if (is_null($model))
           throw new CHttpException(404,'No se encontro ningun documento para estos datos');
	   $modelodetalle=Desolpe::Model()->findByPk($model->hidesolpe);
	   //El inventario siempre se maneja en unidad de medida base;
	   $cantidadenjuego=$model->cant*Alconversiones::convierte($modelodetalle->codart,$modelodetalle->maestro->um);

	   if($model->codocu=='450'){ //si es una reserva
       		if($model->estadoreserva=='10') {

           		 	$model->estadoreserva='30'; //anulare
				//verificando si se puede regresar el status a la desolpe
				///2 criterios : Si existe solo una reserva para esta desolpe se procede pero si existe
				/// adicionalmente una SOLICITUD DE COMPRA para esta misma solped, tambien debe  de anularse
				$reservasasociadas=$modelodetalle->numeroreservas;
				if( $reservasasociadas > 1)
										{ //quier decir que hay UNA SOLCIITUD DE COMNPRA ADICIONAL, tendremos que vaidar gtambien la anulacion de un SOLICITU
										$adicional=Alreserva::model()->find("hidesolpe=".$modelodetalle->id." and id <> ".$id."");
					   					 //Luego intentamos Anular tambien Esta solicitud
											$consulta=Yii::app()->db->createCommand("select count(*) from ".Yii::app()->params['prefijo']."desolpe1 where est <> '20' and idreserva=".$adicional->id." ")->queryScalar();
													if($consulta > 0 ) ///si Existe alguna solpe
															{
																Yii::app()->user->setFlash('error', "No se pudo anular la reserva, ".$model->id."   porque ya está asociada a una solicitud de COMPRA que esta siendo procesada  ");
																Yii::app()->end();
															}else {
																	$adicional->estadoreserva='30';
																	$modelodetalle->est='30';   //Regrear status a la desolpe
																	$model->estadoreserva='30';
															}
										} else { //si no es el caso es muy papaya...
											$modelodetalle->est='30';   //Regrear status a la desolpe
											$model->estadoreserva='30';
												}

					//$command = Yii::app()->db->createCommand("update alreserva set estadoreserva='03'  where hidesolpe =".$id."");
          			// $command->execute();
					//ahora el inventario
						$modeloinventario=Alinventario::model()->findByPk($modelodetalle->desolpe_alinventario->id);
								if(!is_null($modeloinventario)) {
											$modeloinventario->setscenario('modificacantidad');
											$modeloinventario->cantlibre=$modeloinventario->cantlibre+$cantidadenjuego;
											$modeloinventario->cantres=$modeloinventario->cantres-$cantidadenjuego;
																} else {
									Yii::app()->user->setFlash('error', "No se puede anular la reserva, ".$model->id."  Verifique que este material tenga registrado inventario ");
									Yii::app()->end();
														}
								$transaccion=$model->dbConnection->beginTransaction();
						if (  $model->save() and $modelodetalle->save() and $modeloinventario->save() and ( $reservasasociadas > 1)?$adicional->save():true ) {
							  Yii::app()->user->setFlash('success', "Se  anulo la reserva, ".$model->id."   ");
							 $transaccion->commit();
          					}else {
              					$transaccion->rollback();
							Yii::app()->user->setFlash('error', "Hubo un problema al grabar los datos , en la reserva ".$model->id."  , no se pudo anular, revise los escenarios ");

						}
			    }else {///en caso de intentar anular una reserva que no tiene el status CREADO
										Yii::app()->user->setFlash('error', "No se pudo anular la reserva, ".$model->id."  > porque ya esta ".$model->alreserva_estado->estado);
										Yii::app()->end();
			  }
	     }else {  ///en caso de ser una SOLCIITU DE COMPRA


			  				 //VERIFICANDO SI TIENE SOLPES PARA COMPRAS ACTIVAS RELACIONADAS
		   						$consulta1=Yii::app()->db->createCommand("select count(*) from ".Yii::app()->params['prefijo']."desolpe1 where est <> '20' and idreserva=".$id." ")->queryScalar();
		   						if($consulta1 > 0 ) ///si Existe alguna solpe
								{
									Yii::app()->user->setFlash('error', "No se pudo anular la reserva, ".$model->id."   porque ya se solicito a compras");
									Yii::app()->end();
								}else { ///si  npo hay solpes para compra srelaconadas entonces
									    ///verificando primero que no haya una reserva asociada
									   $adicional1=Alreserva::model()->find("hidesolpe=".$modelodetalle->id." and id <> ".$id."");

									   if(!$adicional1===null) { ///si   hay reservas relacionadas

											//Luego intentamos Anular tambien Esta reserva
											                      //veamos , si es una reserva sin atenciones no hay problema
															if($model->estadoreserva=='10') {

																					$modeloinventario=Alinventario::model()->findByPk($modelodetalle->desolpe_alinventario->id);
																					if(!is_null($modeloinventario))
																								{
																							$modeloinventario->setscenario('modificacantidad');
																								$modeloinventario->cantlibre=$modeloinventario->cantlibre+$cantidadenjuego;
																									$modeloinventario->cantres=$modeloinventario->cantres-$cantidadenjuego;
																								} else {
																										Yii::app()->user->setFlash('error', "No se puede anular la reserva, asociada  ".$adicional1->id."  Verifique que este material tenga registrado inventario ");
																												Yii::app()->end();
																					             }
																							$modelodetalle->est='30';
																							$model->estadoreserva='30';//anular
																							$adicional1->estadoreserva='30'; //anular tambien la reserva
																				} else { //aqui si hay problemas porque esta reserva asociada ya esta atendidad
																			Yii::app()->user->setFlash('error', "No se pudo anular esta Solicitud , ".$model->id."   porque hay una reserva asociada que ya ha sido atendida");
																			Yii::app()->end();
																		}

														} else {
														$model->estadoreserva='30';//anular
														$modelodetalle->est='30';//regresar el status de la solped
													}
									//echo "model ".gettype($model)."  modelodetalle  ".gettype($modelodetalle)."  modeloinventario  ".gettype($modeloinventario)."  adicional  ".gettype($adicional1);
									//Yii::app()->end();
									$transaccion=$model->dbConnection->beginTransaction();
									if (  $model->save() and $modelodetalle->save() and (!is_null($adicional1))?$modeloinventario->save():true and (!is_null($adicional1))?$adicional1->save():true )
									   {
										Yii::app()->user->setFlash('success', "Se  anulo la reserva, ".$model->id."   ");
										$transaccion->commit();
									   }else {
										$transaccion->rollback();
										Yii::app()->user->setFlash('error', "Hubo un problema al grabar los datos , en la reserva ".$model->id."  , no se pudo anular, revise los escenarios ");
									  }

								}
	              }
	   foreach(Yii::app()->user->getFlashes() as $key => $message) {
		   echo "*)". $message . "\n";		}


	   */
   }




	public function actionReservaitem($id)	{
		$model=Desolpe::Model()->findByPk($id);
		 if ($model===null)
		 	 throw new CHttpException(404,'No se encontro ningun documento para estos datos');
		if ($model->tipsolpe=='S')
		 	 throw new CHttpException(500,'No se puede reservar un servicio');
			$modelocabecera=Solpe::model()->findByPk($model->hidsolpe);
			if ($modelocabecera->escompra=='1') {
		     throw new CHttpException(500,'No se puede reservar items de solicitudes hechas para compras ');
			 }
					// Uncomment the following line if AJAX validation is needed
					$this->performAjaxValidation($model);
							$model->setscenario('reservar');
		if(isset($_POST['Desolpe']))
		{
			$model->attributes=$_POST['Desolpe'];
			if($model->save())
			{
                $transaccion=$model->dbConnection->beginTransaction();
					$idsolpe=$model->id;
					$cantcompra=$model->cantidad_compras;		 
					$cantreservada=$model->cantidad_reservada;
                 if($cantreservada >0 ) {
                     $modelo=new Alreserva;
                     $modelo->hidesolpe= $idsolpe;
                     $modelo->cant=$cantreservada;
                     $modelo->flag='1';
                    // $model->est='06'; //estado 'RESERVADO'
                     //$modelo->codocu='045';
                             }

                      if($cantcompra > 0) {
                                      $modelin=new Alreserva;
                                      $modelin->hidesolpe= $idsolpe;
                                      $modelin->cant=$cantcompra ;
                                      $modelin->flag='0';
                                    //  $model->est='08'; //'SOLICITADO PARA COMPRA'
                                    //$modelin->codocu='008';
                        }

                $modeloinventario=Alinventario::model()->findByPk($model->desolpe_alinventario->id);
                if(!is_null($modeloinventario)) {
                    $modeloinventario->setscenario('modificacantidad');
                    $modeloinventario->cantlibre=$modeloinventario->cantlibre-$cantreservada*Alconversiones::model()->convierte($modeloinventario->codart,$model->um); ///;
                    $modeloinventario->cantres=$modeloinventario->cantres+$cantreservada*Alconversiones::model()->convierte($modeloinventario->codart,$model->um);
				}

                $model->est=($cantcompra >0 and $cantreservada ==0 )?'80':'60'; ///si es una solicitud exclusiva apra compras el estado es '08'

                                 if(
                                        $model->save() and
                                        ($cantreservada>0)?$modelo->save():true and
                                        $modeloinventario->save() and
                                        ($cantcompra>0)?$modelin->save():true ) {
                                        $transaccion->commit();
                                             } else {
                                                    $transaccion->rollback(); ///regresar todo a como estaba
                                                    throw new CHttpException(404,'carayyyyyy');
                                            }

					 if (!empty($_GET['asDialog']))
												{
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialogdetalle').dialog('close');
													                    window.parent.$('#cru-detalle').attr('src','');
																		window.parent.$.fn.yiiGridView.update('detalle-grid');
																		");
														Yii::app()->end();
												}
			}
		}
		
		 if (!empty($_GET['asDialog']))
		$this->layout = '//layouts/iframe';
				//ECHO $model->id;
		    //Yii::app()->end();  

		$this->render('_form_detalle_reservar',array(
			'model'=>$model, 'idcabeza'=>$model->hidsolpe,
		));
		
	
	}







	
	public function actionCreadetalle($idcabeza,$cest)
	{
		$modelocabeza=Solpe::model()->findbypk($idcabeza);
			 if(is_null($modelocabeza))
			 throw new CHttpException(500,'No existe esta solicitud con este ID');
		if($modelocabeza->estado=='10' OR $modelocabeza->estado=='99' or ($modelocabeza->desolpe_solpe->iduser==yii::app()->end())) {
		$model=new Desolpe;
		$model->valorespordefecto();
		$this->performAjaxValidation($model);
		if(isset($_POST['Desolpe']))
		{
			  $model->attributes=$_POST['Desolpe'];
			  $model->codocu='350';
			  IF($modelocabeza->escompra=='1')
				  $model->setScenario('compra');
			  if($model->save()) {


				  if (!empty($_GET['asDialog']))
				  {
					  //Close the dialog, reset the iframe and update the grid
					  echo CHtml::script("window.parent.$('#cru-dialogdetalle').dialog('close');
													                    window.parent.$('#cru-detalle').attr('src','');
																		window.parent.$.fn.yiiGridView.update('detalle-grid');
																		");
					  $this->refresh();
					  Yii::app()->end();
				  }
			  }

		    }

		 
		// if (!empty($_GET['asDialog']))
		$this->layout = '//layouts/iframe';
		$this->render('_form_detalle',array(
			'model'=>$model, 'idcabeza'=>$idcabeza
		));
		
		} else{ //si ya cambio el estado impisble agregar mas items

			
		   if (!empty($_GET['asDialog']))
		$this->layout = '//layouts/iframe';
		$this->render('vw_imposible',array(
			
		));	
		}
		

	

		
	}



	public function actionCreaservicio($idcabeza,$cest)
	{
		//VERIFICADO PRIMERO SI ES POSIBLE AGREGAR MAS ITEMS

		$modelocabeza=Solpe::model()->findbypk($idcabeza);
		if(is_null($modelocabeza))
			throw new CHttpException(500,'No existe esta solicitud con este ID');
		if($modelocabeza->estado==ESTADO_CREADO OR $modelocabeza->estado==ESTADO_PREVIO) {


			$model=new Desolpe;
			$model->setScenario('servicios');
			$model->valorespordefecto();
			// Uncomment the following line if AJAX validation is needed
			$this->performAjaxValidation($model);

			if(isset($_POST['Desolpe']))
			{
				$model->attributes=$_POST['Desolpe'];
				$model->codocu='350'; ///detalle guia
				$model->tipsolpe='S';  //SERVICIO
				$model->codart=CODIGO_MATERIAL_SERVICIO;
				/*var_dump($model->codart);
				yii::app()->end();*/
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


			}
			// if (!empty($_GET['asDialog']))
			$this->layout = '//layouts/iframe';
			$this->render('_form_servicio',array(
				'model'=>$model, 'idcabeza'=>$idcabeza
			));

		} else{ //si ya cambio el estado impisble agregar mas items

			if (!empty($_GET['asDialog']))
				$this->layout = '//layouts/iframe';
			$this->render('vw_imposible',array(

			));
		}

	}



	/****************************************************
	 *  muestra la vista de configuracion de los eventos
	 *+++++++++++++++++++++++++++++++++++++++++++++++++*/	
	
	
	
	//$datos = CHtml::listData( Almacenes::model()->findAll(),'codalm','nomalm');

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new VwSolpe('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['VwSolpe']))
			$model->attributes=$_GET['VwSolpe'];

        if ($this->isExportRequest()) { //<==== [[ADD THIS BLOCK BEFORE RENDER]]
            //set_time_limit(0); //Uncomment to export lage datasets
            //Add to the csv a single line of text
          //  $this->exportCSV(array('POSTS WITH FILTER:'), null, false);
            //Add to the csv a single model data with 3 empty rows after the data
           // $this->exportCSV($model, array_keys($model->attributeLabels()), false, 3);
            //Add to the csv a lot of models from a CDataProvider

            $this->exportCSV($model->search(), array('numsolpe','item','cant','desum','codart','txtmaterial','fechacrea','fechaent','codal','centro','usuario','est'));
        }






		$this->render('admin',array(
			'model'=>$model,
		));
	}


	public function actionLiberacion()
	{
		$model=new VwSolpe('searchliberacion');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['VwSolpe']))
			$model->attributes=$_GET['VwSolpe'];

		$this->render('liberacion',array(
			'model'=>$model,
		));
	}


	public function actionAprobar($id)
	{

		         							 	///aprobar con pana y elegancia 
		         							 	$modelin=Desolpe::model()->findByPk($id);
		         							 	 $transaccion=$modelin->dbConnection->beginTransaction();
		         							 	$modelin->est='30';//colocar el estado APROBADO
		         							 			$mensa=New Mensajes();
		         							 			$mensa->usuario=Yii::app()->user->name;
		         							 			$mensa->cuando= date("Y-m-d H:i:s"); 
		         							 			//$mensa->nombrefichero=$this->Imprimirsolo($id);
		         							 			$mensa->codocu='350';
		         							 			$mensa->hidocu=$id;
		         							 				// $consulta=Yii::app()->db->createCommand("select count(*) from desolpe where est  in ('01','99') and hidsolpe=".$modelin->hidsolpe." and id <> ".$modelin->id." ")->queryScalar();
															$arreglo=Desolpe::model()->findall(" est  in ('10','99') and hidsolpe=".$modelin->hidsolpe." and id <> ".$modelin->id);
																	if(count($arreglo)==0 ) {//si no hay mas 
				   															$modelosolpe=$this->loadmodel($modelin->hidsolpe);
				   															$modelosolpe->setScenario('aprobacion');
				   															$modelosolpe->estado='20';
				   															$modelosolpe->save();
				   															}
		         							 		  	 if(	 $modelin->save() and $mensa->save()  )	 {	         							 						  	 
		         							 							 $transaccion->commit();
		         							 							} else {
		         							 										 $transaccion->rollback();
															 print_r($modelin->geterrors());
															 print_r($mensa->geterrors());
															 echo " mateiale ".$modelin->codart;

		         							 							}
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Solpe the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Solpe::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Solpe $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='solpe-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


	public function actioncargaimputacion(){
	     $tipo=$_POST['tipoimputacion'];
         $model=new Desolpe;
		 $model->setScenario($_POST['escenario']);
		$form=New CActiveForm;
	switch ($tipo) {
		case 'K':
			echo $this->renderpartial('imputceco',array('model'=>$model,'form'=>$form),true);
			break;
		case 'F':
			echo $this->renderpartial('imputordenventa',array('model'=>$model,'form'=>$form),true);
			break;

	         }

         }


	public function actionpideoferta(){
		$autoIdAll = $_POST['cajita'];
  $mensajeerror="";
		if(count($autoIdAll)>0 )
		{

			foreach($autoIdAll as $autoId)
			{
				$modelo=Desolpe::model()->findByPk($autoId);
				if(!is_null($modelo)){
					$registros=Maestroclipro::model()->findAll("codart=:vcodigo",array(":vcodigo"=>$modelo->codart));
					foreach($registros as $fila){
						///datos de los usuarios a enviar

						$mensajeerror.= yii::app()->correo->correo_simple(
							Contactos::getListMailEmpresa($fila->codpro,'210'),
							Yii::app()->user->email,
							'SOLICITUD DE COTIZACION',
							'Este es un correo automatico, hay nuevas peticiones de oferta, revisar tu buzon'
						);
						if($mensajeerror=="")
							Echo " Se ha enviado las peticiones de oferta correspondientes";





						$modelito=Ofertas::model()->find("id=:vid",array(":vid"=>$modelo->id));
						if(is_null($modelito)){
							$modelito=new Ofertas();
							$modelito->setAttributes(
								array(
									'hidmaestroclipro'=>$fila->id,
									'fechaprog'=>$modelo->fechaent,
									'iduser'=>Yii::app()->user->id,
									'fechadoc'=>date('Y-m-d',time()),
									'cant'=>$registros->cant,
									'iddesolpe'=>$modelo->id,

								)
							);
							$modelito->save();
						}

					}


				}

			}


		}
		if($mensajeerror=="")
			Echo " Se ha enviado las peticiones de oferta correspondientes";
			}


}
