<?php
CONST ESTADO_PREVIO='99';
CONST ESTADO_CREADO='10';
CONST ESTADO_ANULADO='50';
CONST ESTADO_MODIFICADO='50';
CONST ESTADO_ACEPTADO='30';
CONST ESTADO_CON_ENTREGAS='30';
CONST ESTADO_FACTURADO_PARCIAL='70';
CONST ESTADO_FACTURADO_TOTAL='40';
CONST ESTADO_DESOLPECOMPRA_NUEVO='10';  // DESOLPECOMRPA CREADO
CONST ESTADO_DESOLPECOMPRA_APROBADO='20';// DESOLPECOMRPA APROBADO
CONST ESTADO_DESOLPECOMPRA_ANULADO='30';// DESOLPECOMRPA ANULADO
CONST ESTADO_DOCOMPRA_NUEVO='10';  // DESOLPECOMRPA CREADO
CONST ESTADO_DOCOMPRA_APROBADO='20';// DESOLPECOMRPA APROBADO
CONST ESTADO_DOCOMPRA_ANULADO='40';// DESOLPECOMRPA ANULADO
const ESTADO_DESOLPECOMPRA_ANULADO='30';
class OcompraController extends ControladorBase
{

    public $layout='//layouts/column2';

    public function __construct() {
        parent::__construct($id='ocompra',Null);
        $this->documento='210';
        $this->modelopadre='Ocompra';
        $this->modeloshijos=array('Docompra'=>'Docompratemp');
        $this->documentohijo='220';
        $this->campoestado="codestado";
        $this->ConfigArreglos();
        //$nuevo=new $this->modelopadre;
        //$this->campoenlace=$nuevo->getFieldLink($nuevo->relations(),$this->modelopadre,);

    }

    public function actionCreaDocumento()
    {

        $this->ClearBuffer(null);
        $model=new $this->modelopadre;
        $model->valorespordefecto();
        $this->performAjaxValidation($model);
        $model->iduser=Yii::app()->user->id;
        if(isset($_POST[$this->modelopadre]))
        {

            $model->attributes=$_POST[$this->modelopadre];
            $model->coddocu=$this->documento;
            if($model->save()){

                $this->redirect(array('EditaDocumento','id'=>$model->idguia));
                //$this->limpiatemporal();
                //$model->refresh();
            }
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }


    public function actionEditaDocumento($id)
    {
        $model=MiFactoria::CargaModelo($this->modelopadre,$id);
        if(count($model->ocompra_tenorsup)==0  or count($model->ocompra_tenorinf)==0)
            yii::app()->user->setFlash('notice','Favor de definir los tenores para lo valores de la posicion y la sociedad');

        if($model->{$this->campoestado}==ESTADO_PREVIO)
            $model->{$this->campoestado}=ESTADO_CREADO;
        if($this->itsFirsTime($id))
        {
            $uintruso=$this->getUsersWorkingNow($id);
            if($uintruso)
            { //si esta ocupado
                Yii::app()->user->setFlash('error', "Solo puede visualizar, este documento, esta siendo modificado por el usuario    :     <b>". Yii::app()->user->um->loadUserById($uintruso)->username." </b>");
                 $this->redirect(array('VerDocumento','id'=>$model->idguia));
            } else { // Si no lo esta renderizar sin mas
                $this->setBloqueo($id) ; 	///bloquea
                $this->ClearBuffer($id); //Limpia temporal antes de levantar
                $this->IniciaBuffer($id); //Levanta temporales
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
                    $this->render('update',array('model'=>$model));
                    yii::app()->end();
                } else {
                    $this->performAjaxValidation($model);
                    IF(isset($_POST[$this->modelopadre])) {
                        $model->attributes=$_POST[$this->modelopadre];
                        //$model->validate();
                        //	if($this->hubocambiodetalle($id) OR  $model->hacambiado()) {
                        if(true) {
                            if($model->save()){
                                $this->ConfirmaBuffer($id); //Levanta temporales
                                //$this->grabaitems($this->tempdpeticion_a_dpeticion($id)); //Graba temporales a la tabla Dpeticion
                               $this->ClearBuffer($id);
                                //$this->limpiatemporaldetalle(); //Limpia temporal
                                $this->terminabloqueo($id);
                                //$this->terminabloqueo($id); // Desbloquea

                                Yii::app()->user->setFlash('success', "Se grabo el documento  ".$this->SQL);
                                //$this->render('update',array('model'=>$model));
                                $this->redirect(array('VerDocumento','id'=>$model->idguia));
                            } else {
                                //echo CActiveForm::validate($model);
                                $this->render('update',array('model'=>$model));
                                yii::app()->end();
                                /*Yii::app()->end();
                                throw new CHttpException(500,'Hubo un error al momento de grabar la cabecera');*/
                            }
                        } else   {
                            Yii::app()->user->setFlash('notice', "  Enviaste los datos pero no has modificado nada.... ");
                            $this->render('update',array('model'=>$model));
                            yii::app()->end();
                        }
                    } else  { //En este caso quiere decir que la sesion/bloqueo anterior no se ha cerrado correactmente
                        // Y es posble que haya entrado despues de 2 dias, una semana asi
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


public function actionVerDocumento($id){
    $editable=false;
   $model= $this->loadModel((int)$id);
   // $this->ClearBuffer($id); //Limpia temporal antes de levantar
  //  $this->IniciaBuffer($id); //Levanta temporales
    $this->render('_view',array(
        'model'=>$model,'editable'=>$editable,
    ));



                        }

    public function actionRefrescadescuento(){
        $idguia=MiFactoria::cleanInput($_POST['Ocompra']['idguia']);
       $model=$this->loadModel($idguia);
       $model->actualizadescuento(MiFactoria::cleanInput($_POST['Ocompra']['descuento']));
       // echo "salio    ".$idguia;
    }




    public function actionCreadetalle($idcabeza,$cest)
    {
 $modelopadre=$this->loadModel($idcabeza);
        $descuento=(is_null($modelopadre->descuento))?0:(1-$modelopadre->descuento/100);
            $model=new Docompratemp();
        $model->estadodetalle=ESTADO_PREVIO;
        $model->idusertemp=Yii::app()->user->id;
            $model->valorespordefecto($this->documentohijo);
            if(isset($_POST['Docompratemp']))		{
                $model->attributes=$_POST['Docompratemp'];
                $model->coddocu=$this->documentohijo; ///detalle guia
                $model->hidguia=$idcabeza;
                $model->punitdes=$model->punit*$descuento;
                //crietria para filtrar la cantidad de items del detalle
                $criterio=new CDbCriteria;
                $criterio->condition="hidguia=:idguia  ";
                $criterio->params=array(':idguia'=>$idcabeza);
                $model->item=str_pad(Docompratemp::model()->count($criterio)+1,3,"0",STR_PAD_LEFT);
                //str_pad($somevariable,$anchocampo,"0",STR_PAD_LEFT);
                ////con esto calculamos el numero de items
                //echo "  El valor de  ".$idcabeza."       ".$model->n_hguia."   ";
                if($model->save()){
                    if (!empty($_GET['asDialog']))
                    {
                        //Close the dialog, reset the iframe and update the grid
                        echo CHtml::script("window.parent.$('#cru-dialogdetalle').dialog('close');
													                    window.parent.$('#cru-detalle').attr('src','');
																		window.parent.$.fn.yiiGridView.update('detalle-grid');
																		window.parent.$.fn.yiiGridView.update('resumen-grid');
																		");

                    }
                } else {
                    print_r($model->geterrors());
                }
                Yii::app()->end();
            }
            // if (!empty($_GET['asDialog']))
            $this->layout = '//layouts/iframe';
            $this->render('_form_detalle',array(
                'model'=>$model, 'idcabeza'=>$idcabeza
            ));
    }



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
				'actions'=>array('enviarpdf','admin','borrarimpuesto','reporte','agregarmasivamente','cargadirecciones','borraitems','sacaitem','sacaum','salir','agregaimpuesto','agregaritemsolpe','procesardocumento','refrescadescuento','VerDocumento','EditaDocumento','creadocumento','Agregardelmaletin','borraitem','imprimirsolo','cargaentregas','agregarsolpe','agregarsolpetotal','pasaatemporal','create','imprimirsolo','imprimir','imprimir2','enviarmail',
					'procesaroc','hijo','Aprobaroc','Reporteoc','Anularoc','Configuraop','Revertiroc', ///acciones de proceso
					'libmasiva','creadetalle','Verdetalle','muestraimput','update','nada','Modificadetalle'),
				'users'=>array('@'),
			),

			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}



public function actionborrarimpuesto($id) {
    $id=(int)MiFactoria::cleanInput($id);
    $reg=Impuestosdocuaplicado::model()->findByPk($id);
    $reg->delete();


                    }



    ///ESTA FUNCION SE ENCARGA DE AGREAR UN REGISTRO DE DOCOMPRA Y LO DEJA
    /// LISTO PARA VALIDARLO EN LE PROCESO SAVE() DEL ACTION CREADETALE DEL DOCUMENTO PADRE
    ///RESUMEN: COLOCARLO INMEDIATAMENTE DESPUES DE:  ACTIONCREDETALLE()
    ///RESUELVE TODOS LOS CASOS DE LA COMPRA
    ///parametro $modelodetalle : Un registro original de Docompra ,
    //a

    public function preparaitem($modelodetalle,$modelocompra,$iddesolpe=null) {
        $mensa="";
        if($modelodetalle->isNewRecord){
             $registro=New Docomprat;
            $registro->iddocompra=-1;
            $registro->valorespordefecto();
            $registro->hidguia=$modelocompra->idguia;
            if(!is_null($iddesolpe));
            $registro->iddesolpe=$iddesolpe;

        }  else {/// sI ES UN REGISTRO EXISTENTE
              ///Verificar si el status de la OC lo permite
            if($modelodetalle->desolpe_solpe->codestado =='10' or $modelodetalle->desolpe_solpe->codestado =='20'){
                        ///Clonar el registro a Docomprat;
                 $registro=$this->clonaDocomprat($modelodetalle,$iddesolpe);
                 return $registro;

             } else {
                $mensa.=" El status de la OC no permite agregar mas items <br>";
                Return $mensa;
            }
                                                                                                                                                                                                                                                                                                                                                                                                                // $mensa.=" El status de la OC no permite agregar mas items <br>";
        }
    }



    public function clonaDocompra($modelodetalle)  {
        $mensa="";
        if(!is_null($modelodetalle) and  !$modelodetalle->IsNewRecord) {
            $docompratemporal=new Docompra;
            $docompratemporal->tipoimputacion= $modelodetalle->tipoimputacion;
            $docompratemporal->codentro= $modelodetalle->codentro;
            $docompratemporal->codigoalma= $modelodetalle->codigoalma;
            $docompratemporal->descri=$modelodetalle->descri;
            $docompratemporal->detalle=$modelodetalle->detalle;
            $docompratemporal->ceco=$modelodetalle->ceco;
            $docompratemporal->um=$modelodetalle->um;
            $docompratemporal->tipoitem=$modelodetalle->tipoitem;
            $docompratemporal->cant=$modelodetalle->cant;
            $docompratemporal->codart=$modelodetalle->codart;
            $docompratemporal->punit=0;
            $docompratemporal->iddesolpe=$iddesolpe;///es un  parametro para indincar que Docompra es libre o relacopnada
           // $docompratemporal->iddocompra=$modelodetalle->iddocompra; //importante para que pueda pasar al terompral como un regiustro agregado
            $docompratemporal->hidguia=$hidguia; //importante para que pueda pasar al terompral como un regiustro agregado
            $docompratemporal->setscenario('clonasolpe');
            // $docompratemporal->save();
            return $docompratemporal;
        } else {
            $mensa.=" El registro o modelo pasado como para metro para clonar el detalle de la Solpe no existe o es un registro recien creado <br>";
            return $mensa;
        }

    }

public function actionsalir($id){
    $this->out($id);
    $this->redirect(array('admin'));
}



    public function hubocambios($modelo) {

        return $modelo->hubocambios();










        }




    ///
    //BOOLEAN: verifica si se han mdificado algunso de lso campos pasados como paramertos en el array $campossensibles
    public function hubocambiossensibles($modelo,$campossensibles) {
       $retorno=false;
        $camposmodificados=$modelo->cambios();
         foreach ($camposmodificados as  $value) {
             if(in_array($value,$campossensibles) )
                 $retorno=true;
                  break;


                      }
        return $retorno;
    }

//El parametro $iddesolpe detrermina si es un item libre o esta relacionado a una solpe
///de aprovisionamiento
  public function preparaantesdeguardaritemcompra($modelodetalle){
            $cadenita="";

          if(($modelodetalle->docompra_ocompra->codestado='10') or ($modelodetalle->docompra_ocompra->codestado='20')){
                    if($modelodetalle->cambio()) {
                                    if($this->hubocambiossensibles($modelodetalle,array('codart','punit','cant','estadodetalle'))) {
                                                     if($modelodetalle->cantidadentregada == 0) {
                                                                                                if(!is_null($modelodetalle->iddesolpe)) { ///NO ES UN ITEM LIBRE

                                                                                                         ///vERIFICAR LA CONSIUSTENCIA DEL VALOR DEL PARAMETRO ENTREGADO
                                                                                                             $registrodetallesolpe=Desolpe::model()->findByPk($modelodetalle->iddesolpe);
                                                                                                           if(!is_null($registrodetallesolpe)){
                                                                                                                 if($registrodetallesolpe->desolpe_solpe->escompra !='1' or is_null($registrodetallesolpe->idreserva) ){
                                                                                                                            ///Actualizar los datos aguas arriba (SOLPES Y RESERVAS)


                                                                                                                                     $registrodetallesolpe->SetScenario('cambiaestado');
                                                                                                                                     $registroreserva=Alreserva::model()->findByPk($registrodetallesolpe->idreserva);
                                                                                                                                          if( !is_null($registroreserva)) {
                                                                                                                                                $registroreserva->SetScenario('cambiaestado');
                                                                                                                                                  //Ahora vamos por la solpe que genero la reserva
                                                                                                                                                  $registrodetallesolpeoriginal=Desolpe::model()->findByPk($registroreserva->hidesolpe);
                                                                                                                                                             if( !is_null($registrodetallesolpeoriginal)) {

                                                                                                                                                                                                 $registrodetallesolpeoriginal->SetScenario('cambiaestado');

                                                                                                                                                                                        ///Verificando las compras en DESOLPECOMPRA
                                                                                                                                                                                                         $cantidad_comprada=$registrodetallesolpe->cantcompras;
                                                                                                                                                                            if($cantidad_comprada > 0)   ///SI YA HABIDO ATENCIONES EN LA TABLA DESOLPECOMPRA
                                                                                                                                                                                      {

                                                                                                                                                                                          $setratadeanulacion=false;
                                                                                                                                                                                                        if(($modelodetalle->oldattributes['estadodetalle'] <> '40') and ($modelodetalle->estadodetalle=='40'))
                                                                                                                                                                                                         {  ///Si se trata de una anulacion hay que anular el registro de DESOLPECOMPRA
                                                                                                                                                                                                                            $nuevocriterio=New CDbcriteria;
                                                                                                                                                                                                                             $nuevocriterio->addCondition("iddesolpe=:xiddesolpe AND iddocompra=:xiddocompra ");
                                                                                                                                                                                                                             $nuevocriterio->params=array(':xiddesolpe'=>$modelodetalle->iddesolpe,':xiddocompra'=>$modelodetalle->id);
                                                                                                                                                                                                                            $modelodesolpecompra=Desolpecompra::model()->find($nuevocriterio);
                                                                                                                                                                                                                        $modelodesolpecompra->codestado='30'; //ANULAR  ......!!!!
                                                                                                                                                                                                                             if(!$modelodesolpecompra->save())
                                                                                                                                                                                                                             $cadena.=" El item ".$modelodetalle->item." - ".$modelodetalle->descri."  : No se pudo anular el registro de Detalles-solicitudes/Detalle-compras  <br>";
                                                                                                                                                                                                                             $setratadeanulacion=true;
                                                                                                                                                                                                            }


                                                                                                                                                                                          if( $cantidad_comprada +$modelodetalle->cant ==$registrodetallesolpe->cant)
                                                                                                                                                                                            {
                                                                                                                                                                                         //Es una atencion unica el caso mas simple, uno a uno
                                                                                                                                                                                                   ///Verificar si se trata de una anulacion
                                                                                                                                                                                                 if($setratadeanulacion)
                                                                                                                                                                                                           {
                                                                                                                                                                                                               ///El proceso retrocede, hayq ue anular tambien el registro de la tab la puente DESOLPECOMPRA
                                                                                                                                                                                                               /// y revertir los estados
                                                                                                                                                                                                               $registrodetallesolpe->est='30'; //APROBADO
                                                                                                                                                                                                               $registroreserva->estadoreserva='20'; //EN PROICESO DE COMPRA X Q LA SOLPE AUN PERMANECE COMO APROBADA
                                                                                                                                                                                                               $registrodetallesolpeoriginal->est='70'; ///EN PROCESO DE COMPRA X Q LA RESERVA Y LA SOLPE AUN ESTAN VIGENTES


                                                                                                                                                                                                              } else { ///Si no se trata de una anulacion el proceso "evoluciona"
                                                                                                                                                                                                                                 $registrodetallesolpe->est='40'; //ATENDIDO
                                                                                                                                                                                                                                $registroreserva->estadoreserva='50'; //COMPRADO TOTALMENTE
                                                                                                                                                                                                                                $registrodetallesolpeoriginal->est='90'; ///Comprado totalmente
                                                                                                                                                                                                              }




                                                                                                                                                                                             } else { //Significa que conn esta compra aun falta o se han excedido..veamos
                                                                                                                                                                                                         if( $cantidad_comprada +$modelodetalle->cant < $registrodetallesolpe->cant) {
                                                                                                                                                                                                                // En este caso se esta comprando pero aun falta completar, un abastecimiento parcial
                                                                                                                                                                                                                    $registrodetallesolpe->est='70'; //EN COMPRA
                                                                                                                                                                                                                    $registroreserva->estadoreserva='60'; //EN COMPRA

                                                                                                                                                                                                             } else { ///Error se pasaron de la cantidad solicitada
                                                                                                                                                                                                             ///Error
                                                                                                                                                                                                             $cadena.=" El item ".$modelodetalle->item." - ".$modelodetalle->descri."  : Se esta comprando : (".($cantidad_comprada +$modelodetalle->cant).")   mas de lo que se solicito :(".$registrodetallesolpe->cant.")  en la solicitud ".$registrodetallesolpe->desolpe_solpe->nunero."-".$registrodetallesolpe->item."    <br>";


                                                                                                                                                                                                             }

                                                                                                                                                                                               }

                                                                                                                                                                                       } else { ///qUIER DECIR QUE ES LA PRIMERA VEZ QUE SE ATENDERIA ESTE ITEM

                                                                                                                                                                                           }
                                                                                                                                                                          $registrodetallesolpeoriginal->save();
                                                                                                                                                                        } else { //Error no se pudo ubicar el detalle de la Solpe Padre
                                                                                                                                                                 //eRRROR
                                                                                                                                                                 $cadena.=" El item ".$modelodetalle->item." - ".$modelodetalle->descri."  : No se pudo encontrar la solicitud original (Imputada) asociada (".$registroreserva->hidesolpe.")  <br>";

                                                                                                                                                             }
                                                                                                                                                        $registroreserva->save();
                                                                                                                                                   } else { //Error no se ecnontro la reserva que genero la solpe de aprovisionamiento
                                                                                                                                              $cadena.=" El item ".$modelodetalle->item." - ".$modelodetalle->descri."  : No se pudo encontrar la reserva asociada <br>";

                                                                                                                                          }
                                                                                                                            $registrodetallesolpe->save();
                                                                                                                         } else {///Error , La solpe no es de aprovisionamiento o tiene el campo idererva vacio  lo qaue quiere decir que no es una solpe de aprovisionamiento
                                                                                                                  ///Error
                                                                                                                     $cadena.=" El item ".$modelodetalle->item." - ".$modelodetalle->descri."  : La solicitud asociada ".$registrodetallesolpe->desolpe->solpe->numero."-".$registrodetallesolpe->item."  no es de àprovisionamiento <br>";

                                                                                                                            }
                                                                                                            } else {///Error , este detakke de solped no existe
                                                                                                               $cadena.=" El item ".$modelodetalle->item." - ".$modelodetalle->descri."  : No se pudo encontrar la solicitud asociada -> (".$modelodetalle->iddesolpe.")  <br>";

                                                                                                            }
                                                                                                      /*}else{ // ($modelodetalle->cantsolpes) =0 ES LA PRIMERA ATENCION , OSEA NO HAY REGISTROS EN DESOLPECOMPRA

                                                                                                         }*/

                                                                                                } else { //ES UN ITEM LIBRE

                                                                                                      return $cadena;
                                                                                                    }


                                                            } else { //HAY enetregas
                                                                      $cadena.=" El item ".$modelodetalle->item." - ".$modelodetalle->descri." :  Ya tiene entregas y no es posible modificar estos datos sensibles <br>";


                                                                }

                                          } else { //No ha habido cambios sensibles
                                           ///Dara fin al procedimiento
                                          return $cadena;
                                          }

                             } else { //Terminar el procediiento
                                    ///Dara fin al procedimiento
                              return $cadena;
                            }
  }

  }


    public function clonaDocomprat($modelodetalle)  {
            $mensa="";
            if(!is_null($modelodetalle) and  !$modelodetalle->IsNewRecord) {
                $docompratemporal=new Docomprat;
                $docompratemporal->tipoimputacion= $modelodetalle->tipoimputacion;
                $docompratemporal->codentro= $modelodetalle->codentro;
                $docompratemporal->codigoalma= $modelodetalle->codigoalma;
                $docompratemporal->descri=$modelodetalle->descri;
                $docompratemporal->detalle=$modelodetalle->detalle;
                $docompratemporal->ceco=$modelodetalle->ceco;
                $docompratemporal->um=$modelodetalle->um;
                $docompratemporal->tipoitem=$modelodetalle->tipoitem;
                $docompratemporal->cant=$modelodetalle->cant;
                $docompratemporal->codart=$modelodetalle->codart;
                $docompratemporal->punit=0;
                $docompratemporal->iddesolpe=$iddesolpe;///es un  parametro para indincar que Docompra es libre o relacopnada
                $docompratemporal->iddocompra=$modelodetalle->iddocompra; //importante para que pueda pasar al terompral como un regiustro agregado
                $docompratemporal->hidguia=$hidguia; //importante para que pueda pasar al terompral como un regiustro agregado
                $docompratemporal->setscenario('clonasolpe');
               // $docompratemporal->save();
                 return $docompratemporal;
            } else {
                $mensa.=" El registro o modelo pasado como para metro para clonar el detalle de la Solpe no existe o es un registro recien creado <br>";
                return $mensa;
            }

        }






public function actionsacaitem(){

    $registrosolpe=Solpe::recordByNumero(MiFactoria::cleanInput($_POST['Solpe']['numero']));
    if(!is_null($registrosolpe)){
        foreach($registrosolpe->solpe_desolpe as $fila){

                echo CHtml::tag('option', array('value'=>$fila->id),CHtml::encode($fila->item." - ".$fila->txtmaterial),true);

        }
    }else {
         echo "";
    }


}

    public function actionsacaum(){

        $registro=Desolpe::model()->findByPk((MiFactoria::cleanInput($_POST['idsolpex'])));
        if(!is_null($registro)){
            $unidades=Alconversiones::Listadoums($registro->codart);
            foreach($unidades as $clave=>$valor){

                echo CHtml::tag('option', array('value'=>$clave),CHtml::encode($valor),true);

            }
        }else {
            echo "";
        }


    }



    public function actioncargadirecciones(){

        $registros=Sociedades::model()->findAll( "socio=:vc_hcod",array(":vc_hcod"=>(MiFactoria::cleanInput($_POST['socito'])) ));


            foreach($registros as $fila){
                $modelclipro=Clipro::model()->find("rucpro=:vrucpro",array(":vrucpro"=>trim($fila->rucsoc)));
                  if( !is_null($modelclipro)){
                      foreach($modelclipro->direcciones as $filadireccion){
                          echo CHtml::tag('option', array('value'=>$filadireccion->n_direc),CHtml::encode($filadireccion->c_direc),true);
                      }
                  }else {

                  }

                break;
            }



    }

    public function devuelvehijos($id){
        $registroshijos =Docompra::model()->findAllBySql(" select *from
  																".Yii::app()->params['prefijo']."docompra
  																 where
  																 hidguia=".$id." ");
        Return  $registroshijos;

    }

    //agraga itesm masivamente doirectamertne de la vistra VW_SOLPEPARACOMPRAR
    public function actionagregarmasivamente($idguia){
       $modelocabeza= $this->loadModel(MiFactoria::cleanInput($idguia));
        if(isset($_POST['Ocompra']))
        {  $grupoid = $_POST['cajita'];
            $criterio=New CDBcriteria();
            $criterio->addInCondition('id',$grupoid);
            $registros=VwSolpeparacomprar::model()->findAll($criterio);
              foreach($registros as $filadesolpe){
                  $registroitemcompra=New Docompratemp('ingresodesolpe');
                  $this->pasadatosacompra($filadesolpe,$registroitemcompra,$idguia);
                  //ahora verificando las
                  $registroitemcompra->save();
                  IF(count($registroitemcompra->geterrors())>0)
                  {
                      print_r($registroitemcompra->geterrors());
                      yii::app()->end();
                  }
              }
            unset($registroitemcompra);
                if (!empty($_GET['asDialog']))
                {
                    //echo " SON LOS HIJOS  ".count($this->jalasolpetotal($model2->id));
                     echo CHtml::script("window.parent.$('#cru-dialogdetalle').dialog('close');
													                    window.parent.$('#cru-detalle').attr('src','');
																		window.parent.$.fn.yiiGridView.update('detalle-grid');
																		");
                    Yii::app()->end();
                }

              }

        if (!empty($_GET['asDialog']))
            $this->layout = '//layouts/iframe';
        $model=New VwSolpeparacomprar;
        if(isset($_GET['VwSolpeparacomprar']))
            $model->attributes=$_GET['VwSolpeparacomprar'];

        //$model->unsetAttributes();
        $this->render('_formvariositems',array(
            'modelocabeza'=>$modelocabeza,'model'=>$model,
        ));
    }


    ///AGREGA ITEMS A LA OC, autoamticamente desde
    //una solpe de ap`rovisionamiento
    public function jalasolpetotal($id) {
        $mensaje="";
        $modelosolpe=Solpe::model()->findByPk($id);
        if(!is_null($modelosolpe)) {
            if($modelosolpe->escompra=='1'){
                                         $filasdesolpe=Desolpe::model()->findAllBySql(" select *from
  																".Yii::app()->params['prefijo']."desolpe1
  																 where
  																 hidsolpe=".$id." ");
                                            foreach  ( $filasdesolpe as $row) {
                                                ///Veroificando que el detalle de la solpe sea el adecuado y esta habilkitado apra comprar
                                                            //No tiene que estar anulado, ademas la canrtidad atendida no debe de exceder a la cantidad original solicitada
                                                                   if($row->est <> '20' and ($row->cant > $row->cantcompras) ) {
                                                                          $mensaje.=$this->jaladetallesolpe($row);
                                                                        //$mensaje.=" se ejecuto el item ".$row->item."<br>";
                                                                    }
                                                 } //Fin del for
                            } else {
                             $mensaje.="La x solicitud ".$modelosolpe->numero." no es de aprovisionamiento ".$modelosolpe->escompra."<br>";
                         }

        } else  {
            $mensaje.="No se ha podido encotrar la solicitud indicada  ".$id." <br>";
          }
        return $mensaje;
    }

    public function jaladetallesolpe($row) {
        $mensajex="";

        // $r=Desolpe::Model()->findByPk($identidaddetalle);
        $docompratemporal=Docomprat::Model()->find("iddesolpe=:xiddesolpe and estadodetalle not in ('40')",array(":xiddesolpe"=> $row->id));
        if(is_null($docompratemporal))
        {
            $docompratemporal=new Docomprat;
            $docompratemporal->tipoimputacion= $row->tipimputacion;
            $docompratemporal->codentro= $row->centro;
            $docompratemporal->codigoalma= $row->codal;
            $docompratemporal->descri=$row->txtmaterial;
            $docompratemporal->detalle=$row->textodetalle;
            $docompratemporal->ceco=$row->imputacion;
            $docompratemporal->um=$row->um;
            $docompratemporal->tipoitem=$row->tipsolpe;
            $docompratemporal->cant=$row->cant;
            $docompratemporal->codart=$row->codart;
            $docompratemporal->punit=0;
            $docompratemporal->iddesolpe=$row->id;
            $docompratemporal->iddocompra=-1; //importante para que pueda pasar al terompral como un regiustro agregado
            $docompratemporal->hidguia=$hidguia; //importante
            $docompratemporal->setscenario('clonasolpe');
            //crietria para filtrar la cantidad de items del detalle
            $criterio=new CDbCriteria;
            $criterio->condition="hidguia=:nguia  AND idsesion=:idsesionx";
            $criterio->params=array(':nguia'=>$hidguia,':idsesionx'=>Yii::app()->user->getId());
            $docompratemporal->item=str_pad(Docomprat::model()->count($criterio)+1,3,"0",STR_PAD_LEFT);
            //$docompratemporal->estadodetalle='99';
            if(!$docompratemporal->save())
                $mensajex.="No se pudo clonar el item de ".$row->item."  ".$row->txtmaterial." Error al tratar de grabar el detalle de la OC ";
            //echo $docompratemporal->save();
            //Yii::app()->end();

    }
        return $mensajex;
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

    public function actionHijo(){
        $modelo=Docompra::model()->findBypK(3);
        $modelo->cant=3;
        $modelo->codart='1d800560';

        $campos=array('codart','cant','punit');
        $boleano=$this->hubocambiossensibles($modelo,$campos);
       /* print_r($array_modificados);
        echo "<br>";
        print_r($modelo->getAttributes());
        echo "<br>";
        print_r($modelo->getOldAttributes());*/
        echo " se modsidfico campoos sensibles ".$boleano;
        Yii::app()->end();

$fecha1 = Yii::app()->db->createCommand(" SELECT min(fechadoc) from public_alkardex ")->queryScalar();
  echo gettype($fecha1)." -  ".$fecha1;
    }


	/****************************************************
	 *	crea un item segun  solpe
	 ****************************************************/
	public function actionAgregarsolpetotal($idcabeza,$cest)
	{
	if($cest=='10' OR $cest=='99') {
		$model=new Solpe;
       $model->setscenario("agregaritemscompra");
		$this->performAjaxValidation1($model);
		if(isset($_POST['Solpe']))
		{
			$model2=Solpe::model()->find("numero=:xnumero", array(":xnumero"=>$_POST['Solpe']['numero']));
            $transaccion=$model2->dbConnection->beginTransaction();
			//$model->setscenario("xxx");
                $mensaje.=$this->jalasolpetotal($model2->id);
               // $mensaje.="sdsd";
					if(strlen(trim($mensaje))==0){//si no hubo errores
                        $transaccion->commit();
					            if (!empty($_GET['asDialog']))
												{
												//echo " SON LOS HIJOS  ".count($this->jalasolpetotal($model2->id));
                                                  //  print_r($this->devuelvehijos($model2->id));
                                                   //Yii::app()->end();
														//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialogdetalle').dialog('close');
													                    window.parent.$('#cru-detalle').attr('src','');
																		window.parent.$.fn.yiiGridView.update('detalle-grid');
																		window.parent.$.fn.yiiGridView.update('resumen-grid');
																		");
														Yii::app()->end();
												}
                    } else {
                        $transaccion->rollback();
                        Yii::app()->user->setFlash('error', "No se pudo grabar el documento, hay  errores  :".$mensaje);
                        $this->layout = '//layouts/iframe';

                        $this->render('_form_detalle_solpe_total',array(
                            'model'=>$model2, 'mensaje'=>$mensaje
                        ));
                       // $model->refresh();
                        //$this->render('update',array('model'=>$model);
                        yii::app()->end();
                        //$model->refresh();
                    }
		}

		 if (!empty($_GET['asDialog']))
		$this->layout = '//layouts/iframe';

		$this->render('_form_detalle_solpe_total',array(
			'model'=>$model, 'idcabeza'=>$idcabeza
		));

		} else{ //si ya cambio el estado impisble agregar mas items

		   if (!empty($_GET['asDialog']))
		$this->layout = '//layouts/iframe';
		$this->render('vw_imposible',array(

		));
		}

	}
private function pasadatosacompra($desolp,$docomp,$idguia){
    $docomp->setAttributes(
        array(
            'tipoitem'=>$desolp->tipsolpe,
            'tipoimputacion'=>$desolp->tipimputacion,
            'hidguia'=>$idguia,
            'iddesolpe'=>$desolp->id,
            'codentro'=>$desolp->centro,
            'codigoalma'=>$desolp->codal,
            'codart'=>$desolp->codart,
            'descri'=>$desolp->txtmaterial,
            //'tipoimputacion'=>$desolp->tipimputacion,
            //'tipoitem'=>$desolp->tipsolpe,
            'cant'=>$desolp->cant_pendiente,
            'um'=>$desolp->um,
            'punit'=>$desolp->punitplan,
        ),true);
}

    public function Actionagregaritemsolpe($idguia){
            $model=New Solpe;
        $modelocompra=$this->loadModel($idguia);
        $detallecompra=New Docompratemp();
        $model->setScenario('jalaitemparacompras');
        if(isset($_POST['Solpe']))
        {

            $itemsolpe=Solpe::recordByNumeroItem(MiFactoria::cleanInput($_POST['Solpe']['numero']),MiFactoria::cleanInput($_POST['Solpe']['item']));
            $itemsolpe->setScenario('ingresodesolpe');
            $model=$itemsolpe->desolpe_solpe;
            $model->setScenario('jalaitemparacompras');
            $model->attributes=$_POST['Solpe'];
            if($model->validate()){
                $detallecompra->setScenario('ingresodesolpe');
                $detallecompra->attributes=$_POST['Docompratemp'];
                $this->pasadatosacompra($itemsolpe,$detallecompra,$idguia);
                $criterio=new CDbCriteria;
                $criterio->condition="hidguia=:idguia  ";
                $criterio->params=array(':idguia'=>$idguia);
                $detallecompra->setattributes(
                    array(
                        'estadodetalle'=>ESTADO_PREVIO,
                        'coddocu'=>$this->documentohijo,
                        'hidguia'=>$idguia,
                        'idusertemp'=>Yii::app()->user->id,
                        //'idstatus'=>1,
                        'item'=>str_pad(Docompratemp::model()->count($criterio)+1,3,"0",STR_PAD_LEFT),
                    ),
                    true
                );

                //$detallecompra->validate();
                if($detallecompra->save()) {
                    if (!empty($_GET['asDialog']))
                    {
                        //Close the dialog, reset the iframe and update the grid
                        echo CHtml::script("window.parent.$('#cru-dialogdetalle').dialog('close');
                                                                             window.parent.$('#cru-detalle').attr('src','');
                                                                             window.parent.$.fn.yiiGridView.update('detalle-grid');
                                                                             window.parent.$.fn.yiiGridView.update('resumen-grid');
                                                                             ");
                        Yii::app()->end();
                    }
                    /*var_dump ( $detallecompra->geterrors () );
                    yii::app ()->end ();*/
                }




            }else {
                /*print_r($model->geterrors());
                yii::app()->end();*/
            }


        }
        if (!empty($_GET['asDialog']))
            $this->layout = '//layouts/iframe';

        $this->render('_form_detalle_solpe_item',array(
            'model'=>$model,'modelocompra'=>$detallecompra
        ));


    }



    /****************************************************
     *	crea un item segun  solpe y la posicion
     ****************************************************/
    public function actionAgregaitemsolpe($idcabeza,$cest)
    {
        if($cest=='10' OR $cest=='99') {
            $model=new Solpe;
            $model->setscenario("agregaritemscompra");
            $this->performAjaxValidation1($model);
            if(isset($_POST['Solpe']))
            {
                $model2=Desolpe::model()->find("numero=:xnumero", array(":xnumero"=>$_POST['Solpe']['numero']));
                //$model->setscenario("xxx");
                $model->Pasacompra($model2->hidsolpe,$idcabeza);
                if (!empty($_GET['asDialog']))
                {
                    //Close the dialog, reset the iframe and update the grid
                    echo CHtml::script("window.parent.$('#cru-dialogdetalle').dialog('close');
													                    window.parent.$('#cru-detalle').attr('src','');
																		window.parent.$.fn.yiiGridView.update('detalle-grid');
																		window.parent.$.fn.yiiGridView.update('resumen-grid');
																		");
                    Yii::app()->end();
                }
            }

            if (!empty($_GET['asDialog']))
                $this->layout = '//layouts/iframe';

            $this->render('_form_detalle_solpe_total',array(
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
     *	crea items que toma del maletin
     ****************************************************/
    public function actionAgregardelmaletin(){

       /* echo "salio";
        yii::app()->end();*/
        $id=(int)MiFactoria::cleanInput($_POST['idcompra']);
$cadena="";
          $modelocompra=$this->loadModel($id);
          $cest=$modelocompra->codestado;
          /*$desolpe=Desolpe::Model()->findBypK($_SESSION['350'][0]);
          $modelosolpe=Solpe::model()->findByPk($desolpe->hidsolpe);*/

          if($cest=='10' OR $cest=='99') {
              //RECORRIENDO LAS DESOLPES DEL MALETIN
              foreach (Yii::app()->session['DOC350'] as $clave=>$valor) {

                  if(!$modelocompra->hayitemsolpe($valor,$modelocompra->idguia))  // si no se ha agregado antes esta IDDesolpe
                      {
                          $NUEV=NEW Docompratemp();
                         if($NUEV->importadesolpe($valor,$modelocompra->idguia))
                          $cadena.="se agrego ...<br>";
                      }


                }



          }
        echo $cadena;
    }


public function Anulaitem($id) { ///Esta accion se encarga de actualizar las tablas relcionadas
    //luego de anular el documento de compras
        $detallecompra=Docompra::model()->findByPk($id);
       if( $detallecompra->iddesolpe > 0) { // Si este detalle esta relacionada con un detalle solpe
           //Borrar el registro de la tabla puente
           $command = Yii::app()->db->createCommand(" DELETE FROM ".Yii::app()->params['prefijo']."desolpecompra  where iddocompra=".$detallecompra->id);
           $command->execute();
                  }
     $command1 = Yii::app()->db->createCommand(" DELETE FROM ".Yii::app()->params['prefijo']."alentregas  where iddetcompras=".$detallecompra->id);
        $command1->execute();

    $command2 = Yii::app()->db->createCommand(" UPDATE ".Yii::app()->params['prefijo']."Docompra SET estadodetalle='40' where id=".$detallecompra->id);
    $command2->execute();
    }


    /*funcion para borra un registro detalle de laorden de compra
      loq ue se hace es verificar que el registro Docompratemp
      no tenga ninguna imagen del registro Docompra correspondiente osea
     que se haya agregado recien

    En el caso que tenag una imagen; lo que hay que hacer es verificar que :
    OJO : El registro Docompra correspondinete  y no el Docompratemp
      1) NO tenga entregas (Flujo futuro)
      2) No tenga detalles de Solpe asociadas (Flujo pasado)


    */
public function borradetalle($id /*idtemp*/) {

    $detalletemp=Docompratemp::model()->findByPk($id /*idtemp*/);

    $mensaje="";
    if(!is_null($detalletemp)) {
        ///verificamos primero si es un registro agregado
        if (is_null($detalletemp->id)) { ///quier decir que no existe una imagen en la tabla opriginal, osea se ha agregado recientemente
            $detalletemp->delete();
            //$detalletemp->save();
            $mensaje.="Se borro el registro";
        } else {// si ya se ha grabado o confirmado en la tabla original
           //buscar en le registro orignal el firma
            $detallefirme=Docompra::model()->findByPk($detalletemp->id);
            // primero verificamos si ha abido entragas
            if ($detallefirme->cantidadentregada > 0) {
                $mensaje .= " El item  " . $detalletemp->item . "  Tiene entregas, no puede ser borrado <br>";

            } else { ///si no tiene entrgas aun no cantemos victoria
                  //OJO QUE ALMOMENTO DE CONFIRMAR EL BUFFER DEBEMOS AEGURARNOQ UE EN EL EVENTO
                  //AFTERSAVE() DEL REGISTRO DOCOMPRA

                $detalletemp->setScenario('cambiaestado');
                $detalletemp->estadodetalle = ESTADO_DOCOMPRA_ANULADO;
                $mensaje .= ($detalletemp->save()) ? "" : " No se pudo anular el item " . $detalletemp->item . "<br>";
            }

        }

    } else {
        $mensaje.="No se encontro ningun registro para borrar con el ID=".$id;
    }

  echo $mensaje;

}





public function borraitem($id) { //ojo es el id de la tabla temporal Docomprat
    //para borrar u item hay varias escenarios
    $detalletemp=Docomprat::model()->findByPk($id);
    if($detalletemp===null) {
        throw new CHttpException(500,'No se encontro el item id del item de la compra');
                    } else{
                                 $transaccion=$detalletemp->dbConnection->beginTransaction();
                                 $modelocompra=Ocompra::model()->findByPk( $detalletemp->hidguia);
                                 if($modelocompra===null)
                                             throw new CHttpException(500,'No se encontro un documento padre de compras para este registro');
                                             /***********ESCENARIO 1 ***********************************************
                                             *   PRIMERO QUE SEA UN ITEM RECIEN AGREGADO ES DECIR  IDDOCOMPRA < 0      *
                                                *********************************************************************/
                                            //En este caso borrar sin asco y desaparecer el registro
                                  if($detalletemp->iddocompra < 0 ) { //registro recien agregado
                                                             $detalletemp->delete();

                                                                      if( !$detalletemp->save() ) {
                                                                                 $transaccion->rollback();
                                                                                     throw new CHttpException(500,'Por alguna razon no se pudo borrar el registro de la solpe ');
                                                                                    }
                                                                 }  else {
                                                                        $detalleoc=Docompra::model()->findByPk($detalletemp->iddocompra);
                                                                        $detalleoc->setscenario('anulaitemcompra');
                                                                        //verificando la consistgencia de los datos para evitar que lo hagan por medio del URL

                                                                        /***********ESCENARIO 2 ***********************************************
                                                                        *   SEGUNDO, QUE SEA UN ITEM  PREEXISTENTE  IDDOCOMPRA > 0      *
                                                                        *********************************************************************/
                                         //En este caso Tenemos que averiguar en los dos extremos :
                                        // Extremo de las SOLPE TABLA PUENTE DESOLPECOMPRA
                                         //Extremo de la INGRESOS TABLA PUENTE ALENTREGAS

                                                    ///EXTREMO DEL PUENTE ENTREGAS , PRIMERO LO MAS RESTRICTIVO, SI HYA RESTRICION AQUI, EL OTR EXTREMO(DESOLPE) YA NI SE ANALIZA
                                                                         $cantidadentregada=$detalleoc->cantidadentregada; ///SUM de cantidades entregadas al alamcen
                                                                         $cantidadsolicitada=$detalleoc->cantsolpes;  ///SUM de cantidades de solpes tomadas en este item
                                                                        if(  $cantidadentregada > 0) { //si ya hay cantidad recbida x el almacen
                                                                            Yii::app()->user->setFlash('error', 'El item '.$detalleoc->docompra_ocompra->numcot.'-'.$detalleoc->item.'  ya tiene entregas or lo tanto no se puede eliminar');
                                                                                // throw new CHttpException(500,'El item '.$detalleoc->docompra_ocompra->numcot.'-'.$detalleoc->item.'  ya tiene entregas or lo tanto no se puede eliminar');


                                                                            }  else {
                                                                            //EN EL OTRO CASO EL EXTREMO DEL TABLA PUENTE DESOLPECOMPRA
                                                                                    if(  $cantidadsolicitada > 0) { //Si hay solpes amarradas a este item
                                                                                                             $detalleoc->estadodetalle='40';  ////SI SE PUEDE , AUQNUE TENGAS QUE BORRAR LOS PUENTES
                                                                                                    //borrar tambien los puentes PERO ESTA TAREA LA HAREMOS AL GRABAR/CONFIRMAR O HACER EL UPDATE TOTAL (PASACOMPRA)
                                                                                                        // $command = Yii::app()->db->createCommand("DELETE FROM  ".Yii::app()->params['prefijo']."desolpecompra WHERE iddocompra= ".$detalleoc->id." ");
                                                                                                                    // $command->execute();
                                                                                                         //Esto significa tambien actualizar las SOLPES, RESERVAS Y DETALLES DE SOLPE


                                                                                                                } else {  //Si no hay solpes amarradas, entonces proceder a anular
                                                                                                                    $detalleoc->estadodetalle='40';

                                                                                                                        }


                                                                                    }



                                                                             }

                                                    if( !$detalleoc->save() ) {
                                                                        $transaccion->rollback();
                                                                        Yii::app()->user->setFlash('error', 'Por alguna razon no se pudo grabar el status del item '.$detalleoc->docompra_ocompra->numcot.'-'.$detalleoc->item.' ');
                                                                         }


                                        $transaccion->commit();

                                       }

     }










public function actionmuestraimput(){

		$valor=$_POST['Docompra']['tipoimputacion'];
		//echo "hola amigos";
	//	if ($valor=='F')
echo CHtml::textField('Docompra_orden','',array('value'=>'hola'));
		//if ($valor=='K')
		//echo CHtml::textField('[Docompra][orden]','',array('value'=>'hola'));
			//echo "<imput size='12' />";


}

public function actionImprimir($id){
	             $nombrearch= $this->Imprimirsolo($id);
        echo CHtml::link("Lista para imprimir",Yii::app()->createUrl('/assets/'.$nombrearch.'.pdf'),array('target'=>'_blank'));
		echo CHtml::link(CHtml::image(Yii::app()->getTheme()->baseUrl.'/img/pdf.png','',array('height'=>'30','width'=>'30')),Yii::app()->createUrl('/assets/'.$nombrearch.'.pdf'),array('target'=>'_blank'));
              }


public function Imprimirsolo($id)
	{

        $ocompra=$this->loadModel($id);

        $usuario=Trabajadores::model()->findByPk(Yii::app()->user->um->getFieldValue(Yii::app()->user->id,'codtrabajador') );
        $cadena=$this->renderpartial('reporteoc',array('ocompra'=>$ocompra,'usuario'=>$usuario),true,true);
      /* echo $cadena;
        yii::app()->end();*/
        $mpdf=Yii::app()->ePdf->mpdf();
        $hojaestilo=file_get_contents('themes/abound/css'.DIRECTORY_SEPARATOR.'estilooc.css');
        $mpdf->WriteHTML($hojaestilo,1);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($cadena,2);
       // $mpdf->Output();
        $vacr=md5(time());
       $mpdf->Output('assets/'.$vacr.'.pdf','F');

        return $vacr;


    }



public function actionImprimir2($id)
	{



				return "hola";


	}



	/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	+
	+	EVENTOS PARA PROCESAR LA GUIA DE REMISION, ASEGURESE DE QUE CADA EVENTO
	+	GENERADO EN TABLAS DEBE DE TENER UNA ACCION AQUI
	+     'Aprobaroc','Anularoc','Revertiroc', ///acciones de proceso
	+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

   ///esta funcion se repite para todas las acciones de procesar la guia
	public function verificaestado($id,$idevento){

						//sacando el estado de la guia,si no necuentra datos genera error
		        $modeloguia=$this->loadmodel($id);
		        $estado=$modeloguia->codestado;
		        $evento=Eventos::model()->findByPk($idevento);
		          if($evento->estadoinicial==$estado ) { //si el estado es el adecuado
		          				return $evento->estadofinal; //devolver el nuevo estado ya que es valido

		          }else {
		          			return null; //en caso de no proceder devolver null

		          }

	          }


 public function actionenviarmail($id) {
    // $id=$_GET['idguia'];
  //mail('hipogea@hotmail.com','rtrt','mimensaje');
    // Yii::app()->crugemailer->mail_attachment('hipogea@hotmail.com' , 'hipogea@hotmail.com', 'adrain ,ariano', 'hipogea@hotmail', 'contesta', 'este esun m,ejase',$this->Imprimirsolo(26));
 // mail ( string $to , string $subject , string $message [, string $additional_headers [, string $additional_parameters ]] )
	//Yii::app()->crugemailer->mail_con_archivo('hipogea@hotmail.com','elena@hotmail.com','esto es');
	//Yii::app()->crugemailer->mail_con_archivo('hipogea@hotmail.com','elena@hotmail.com','esto es','casa');
   $ocompra= $this->loadModel($id);

     //haciendo las verifiaciones primero
   if($ocompra->codestado=='30') {
     $nombrearch= $this->Imprimirsolo($id);
    // echo $this->Imprimirsolo($id);
     $filename=Yii::app()->params['rutaraiz'].'recurso/assets/'.$nombrearch.'.pdf';
     //echo CHtml::link("Lista para imprimir",Yii::app()->createUrl('/assets/'.$nombrearch.'.pdf'),array('target'=>'_blank'));
     $usuario=Trabajadores::model()->findByPk(Yii::app()->user->um->getFieldValue(Yii::app()->user->id,'codtrabajador') );
     $asunto="Orden de compra".$ocompra->numcot."-".$ocompra->codsociedad0->dsocio;
     $nombrecompleto=$usuario->nombres." ".$usuario->ap;
     $mensaje="Este es un correo automático";
     //el mail del contacto
     $mail=$ocompra->contactos->getmails($this->documento);

     Yii::app()->crugemailer->mail_attachment($mail,Yii::app()->user->email, $nombrecompleto, '', $asunto, $mensaje,$filename);


     $transaccion=$ocompra->dbConnection->beginTransaction();

     /* registrar el log de impresiones*/
     $mensa=New Mensajes();
     $mensa->usuario=Yii::app()->user->name;
     $mensa->cuando= date("Y-m-d H:i:s");
     $mensa->nombrefichero= $nombrearch;
     $mensa->codocu='210';
     $mensa->hidocu=$id;

     if ($mensa->save()) {
         $transaccion->commit();


     } else {
         $transaccion->rollback();
         throw new CHttpException(404,'No se pudo grabar el mensaje ');
     }
   } else {
       echo "Este documento no posee el status de APROBADO para efectuar esta acción";
   }
	//Yii::app()->crugemailer->mail_prueba('hipogea@hotmail.com', 'jramirez@neologys.com', 'JORGE ARMAS','jramirez@neologys.com', 'MENSAJE DE', 'SDHKSD SFKSFK FSJFKSF','casa')	;
	//echo "Correo enviado";
}


    public function actioncargaentregas()
    {

        $valor=$_POST['selector_item']+0;
        $idcompra=$_POST['idguia'];
     //  echo var_dump($valor);
      echo  $this->renderPartial('vw_historial', array('ide'=>$valor),TRUE);


    }


   //Idevento=50
	public function actionAprobaroc($id){
		         $sepuedeono=$this->verificaestado($id,50); //obteniendo el estado destino
		         							 if (!$sepuedeono==null) {
		         							 	///aprobar con pana y elegancia
		         							 	$modelin=$this->loadmodel($id);
		         							 	$modelin->codestado=$sepuedeono;//colocar el estadodestino
		         							 	 $transaccion=$modelin->dbConnection->beginTransaction();

		         							 		/* registrar el log de impresiones*/
		         							 			$mensa=New Mensajes();
		         							 			$mensa->usuario=Yii::app()->user->name;
		         							 			$mensa->cuando= date("Y-m-d H:i:s");
		         							 			$mensa->nombrefichero=$this->Imprimirsolo($id);
		         							 			$mensa->codocu='210';
		         							 			$mensa->hidocu=$id;
		         							 				//actualizar tambien los items
		         							 			$command = Yii::app()->db->createCommand(" UPDATE ".Yii::app()->params['prefijo']."docompra set estadodetalle='20' where hidguia=".$modelin->idguia);
														 $command->execute();


		         							 			//Yii::app()->crugemailer->mail_con_archivo('hipogea@hotmail.com','elena@hotmail.com','esto es');
		         							 			//Yii::app()->crugemailer->mail_attachment('hipogea@hotmail.com','elena@hotmail.com', 'julito','hipogea@hotmail.com', 'mensaje para ti', 'este es el mensaje');


		         							 			if ($modelin->save() and $mensa->save()) {
		         							 				$transaccion->commit();
                                                            Yii::app()->user->setFlash('success', "..La Oc de compra se ha autorizado!");
		         							 				//$this->render("update");

		         							 			} else {
                                                            Yii::app()->user->setFlash('error', "..No se ha podido grabar la autorizacion!");
                                                            $transaccion->rollback();
                                                           // $this->render("update");
		         							 				//throw new CHttpException(404,'No se pudieron grabar los datos ');
		         							 			}

		         							 }else{
                                                 Yii::app()->user->setFlash('error', "..Este documento no se puede autorizar por que no tiene el estado adecuado");
                                                // $transaccion->rollback();



										}
        $this->render('update',array(
            'model'=>$modelin,
        ));

    }

 //Idevento=51
	public function actionAnularoc($id){
								$sepuedeono=$this->verificaestado($id,51); //obteniendo el estado destino
		         							 if (!$sepuedeono==null) {
		         							 	///aprobar con pana y elegancia
		         							 	$modelin=$this->loadmodel($id);
                                                 $transaccion=$modelin->dbConnection->beginTransaction();
		         							 	$modelin->codestado=$sepuedeono;//colocar el estadodestino
		         							 	 //luego grabar

                                                 $matrizdetalle= Docompra::model()->findAll( "hidguia=:hidguia  " ,array(":hidguia"=>$id));

                                                 for ($i=0; $i < count($matrizdetalle); $i++) { //recorriendo la cantidad de filas que hay

                                                     $this->Anulaitem($matrizdetalle[$i]['id']);
                                                 }
                                                 if($modelin->save())
                                                     $transaccion->commit();

		         							 	$this->render("vw_procesado");

		         							 }else{
		         							 	throw new CHttpException(404,'Este documento no se puede anular,no tiene el estado adecuado');
		          										}


										}



	 //Idevento=52
	public function actionRevertiroc($id){
												$sepuedeono=$this->verificaestado($id,52); //obteniendo el estado destino
		         							 if (!$sepuedeono==null) {
		         							 	///aprobar con pana y elegancia
		         							 	$modelin=$this->loadmodel($id);
		         							 	$modelin->codestado=$sepuedeono;//colocar el estadodestino
		         							 	$modelin->save(); //luego grabar



		         							 	$this->render("vw_procesado");

		         							 }else{
		         							 	throw new CHttpException(404,'Este documento no se puede confirmar, no es una guia o no tiene el estado adecuado');
		          										}

										}



	public function actionprocesaroc($id)
	{
		$idevento=$_GET['ev'];


			 switch ($idevento) {   ///Luego hacer los procedimientos segun sea el caso

						 case 50 : //autorizar guia
							//$this->redirect("Aprobarguia",array("id"=>$id));
							$this->redirect(array("Aprobaroc",'id'=>$id));
							break;
						case 51: // anular guia
							$this->redirect(array("Anularoc",'id'=>$id));

							break;
						 case 52: //Confirmar
						    $this->redirect(array("Revertiroc",'id'=>$id));
							break;


						default:
								 throw new CHttpException(404,'No existe este procedimiento para el documento');

									 }




	}



/****************************************************
	 *  muestra la vista de configuracion de los eventos
	 *+++++++++++++++++++++++++++++++++++++++++++++++++*/

	public function actionConfiguraop()
	{
        $docu=$this->documento;  //guia de remision
        $docuhijo=$this->documentohijo; //detalle guia de remisio


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











public function actionborraitems()
	{
    /*var_dump($_POST['Ocompra']);
        yii::app()->end();*/
   $modelocabeza=$this->loadModel($_POST['Ocompra']['idguia']);
        if(is_null($modelocabeza))
            throw new CHttpException(500,__CLASS__.'   '.__FUNCTION__.'  No se econtro ningun evento con el id  '.$_POST['Ocompra']['idguia']);

        if($modelocabeza->editable())
   {
       $autoIdAll = $_POST['cajita'];
       $estado=$_POST['Ocompra']['codestado'];
       echo $autoIdAll;
       // Yii::app()->end();
       if(count($autoIdAll)>0 ) //and ($this->eseditable($estado)==''))
       {
           foreach($autoIdAll as $autoId)
           {
               $this->borradetalle($autoId);

           }
       }
   }else
   {
      echo " El documento no se puedfe modificar <br>" ;
   }


	}



      public function hayacceso($id) {
          $matri=Docomprat::model()->findall(" hidguia= ".$id."  and idsesion <>".Yii::app()->user->getId()." ");
          return  (count($matri)==0)?true:false;
      }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Ocompra;
		$model->valorespordefecto();
		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['Ocompra']))
		{
			$model->attributes=$_POST['Ocompra'];
			if($model->save())
			  {
			     $command = Yii::app()->db->createCommand(" delete from ".Yii::app()->params['prefijo']."docompra_t  where idsesion=".Yii::app()->user->getId());
		        $command->execute();
				$this->redirect(array('update','id'=>$model->idguia));

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
        print_r($model-> devuelveimpuestos());
        yii::app()->end();
        //primeor veriifcando que oitri io este metiendo las narices para modificar
        if($this->hayacceso($id) ) {
            $this->performAjaxValidation($model);
                    if(isset($_POST['Ocompra'])){
                          ///Si paso el FORM
                        $model->attributes=$_POST['Ocompra'];
                        $transaccion=$model->dbConnection->beginTransaction();
                        if($model->save()){
                            $this->pasaacompratotal($id,$transaccion);
                            $command = Yii::app()->db->createCommand(" delete from ".Yii::app()->params['prefijo']."docompra_t  where idsesion=".Yii::app()->user->getId());
                            $command->execute();
                            $transaccion->commit();
                            $this->redirect(array('view','id'=>$model->idguia));

                        } ELSE {
                        }

                         } else {
                                         ///Si no se envio el FORMULARIO
                                                ///Si  no se trata de un refresh de la GRILLA, y ademas no es una llamada pare creacion
                                                ////Limpiar la tabla teporal con DELETE
                                               ///Luego llenar esta tabla temporal con los datos de DESOLPE correspondiente
                                                if ( $model->codestado <> '99' AND  !isset($_GET['ajax'])) {

                                                            $command = Yii::app()->db->createCommand(" delete from ".Yii::app()->params['prefijo']."docompra_t  where idsesion=".Yii::app()->user->getId());
                                                            $command->execute();
                                                            $transaccion=$model->dbConnection->beginTransaction();
                                                            $this->pasaatemporaltotal($id,$transaccion);
                                                            $transaccion->commit();
                                                                 }
                            //opk, ya actualizamos el remporal , recien ppodemos mostrar el temporal lleno listo para modificar
                            $this->render('update',array(
                                'model'=>$model,
                            ));
                        }

               } else {
            $this->render('ocupado',array(
                'model'=>$model,
            ));
        }








        /******************************************
         * ANTIGUO CODIGO
         ******************************************/
	    /*
	      $model=$this->loadModel($id);
	   //Primero verifica que otro usuario no este metiendo las narices
	   if($model->hayacceso($id) ) {
		  // ECho isset($_POST['Ocompra']);
		//Yii::app()->end();
		// Uncomment the following line if AJAX validation is needed
	 $this->performAjaxValidation($model);
		if(isset($_POST['Ocompra']))
		{
			$model->attributes=$_POST['Ocompra'];
			 $transaccion=$model->dbConnection->beginTransaction();
			if($model->save()){
			                   $this->pasaacompratotal($id,$transaccion);
								$command = Yii::app()->db->createCommand(" delete from ".Yii::app()->params['prefijo']."docompra_t  where idsesion=".Yii::app()->user->getId());
													 $command->execute();
								$transaccion->commit();
			   				$this->redirect(array('view','id'=>$model->idguia));

			             } ELSE {
			               }
		  } else {  ///Si no se envio el FORMULARIO
		                    if ( $model->codestado <> '99' AND  !isset($_GET['ajax'])) {

		                                  $command = Yii::app()->db->createCommand(" delete from ".Yii::app()->params['prefijo']."docompra_t  where idsesion=".Yii::app()->user->getId());
		                                 $command->execute();
		                                $transaccion=$model->dbConnection->beginTransaction();
			                            $this->pasaatemporaltotal($id,$transaccion);
		                                $transaccion->commit();
		                                                    }
		                 //opk, ya actualizamos el remporal , recien ppodemos mostrar el temporal lleno listo para modificar
		                            $this->render('update',array(
			                                    'model'=>$model,
		                                        ));
		     }

		} else //en caso haya otro usuario que ya ha abierto la OC
		   {
			$this->render('ocupado',array(
			'model'=>$model,
									));
		   }
            */
	}



	public function actionModificadetalle($id)
	{
		$model=Docompratemp::Model()->findByPk(MiFactoria::cleanInput((int)$id));

		 if ($model===null)
		 	  throw new CHttpException(404,'No se encontro ningun documento para estos datos');
        //colocar el escenario correcto
        if($model->iddesolpe > 0 )
            $model->setScenario('ingresodesolpe');

		if(isset($_POST['Docompratemp']))		{
			$model->attributes=$_POST['Docompratemp'];
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

				//$this->redirect(array('view','id'=>$model->n_guia));
		}

		 if (!empty($_GET['asDialog']))
		$this->layout = '//layouts/iframe';

		$this->render('_form_detalle',array(
			'model'=>$model,
		));



	}


     public function actionNada() {
	    if (isset($_POST['Ocompra']['descuento'])){
				$descuento=	$_POST['Ocompra']['descuento']/100;
				$factori=1-$descuento;
					$command = Yii::app()->db->createCommand(" update docompra_t set punitdes=punit*".$factori." where idsesion=".Yii::app()->user->getId());
					//$command = Yii::app()->db->createCommand(" update docompra_t set punitdes=1.35 " );
					$command->execute();
		}

     	//echo "el resultado es ".$_POST['Ocompra']['descuento'];
		Yii::app()->end();
     	return 1;

     }















	/****************************************************
	 *	Retorna una cadena '' o 'disabled' para deshabilitar los controles del form de la vista
	 ****************************************************/
	public function eseditable($estadodelmodelo)
	{
		$retorna='disabled';
        iF(in_array($estadodelmodelo , ARRAY(ESTADO_CREADO,ESTADO_PREVIO,NULL,'',ESTADO_MODIFICADO)) and strtolower($this->action->id) <> 'verdocumento')
          $retorna='';

        RETURN $retorna;
       // if ($estadodelmodelo=='10' or $estadodelmodelo=='99' or empty($estadodelmodelo) or is_null($estadodelmodelo)) {return '';} else{return 'disabled';}
	}


    /****************************************************
     *	Retorna una cadena '' o 'disabled' para deshabilitar los controles del form de la vista
     ****************************************************/
    public function eseditablebase($estadodelmodelo)
    {
        $retorna='disabled';
        iF(in_array($estadodelmodelo , ARRAY(ESTADO_PREVIO,NULL,'')))
            $retorna='';

        RETURN $retorna;
        // if ($estadodelmodelo=='10' or $estadodelmodelo=='99' or empty($estadodelmodelo) or is_null($estadodelmodelo)) {return '';} else{return 'disabled';}
    }

    public function actionReporteoc(){
        $this->render("reporteoc");

    }
	/****************************************************
	 *	crea un item segun  solpe
	 ****************************************************/
	public function actionAgregarsolpe($idcabeza,$cest)	{
		//VERIFICADO PRIMERO SI ES POSIBLE AGREGAR MAS ITEMS
		if($cest=='10' OR $cest=='99') {
		$model=new Docomprat;
		//$model->valorespordefecto();
		// Uncomment the following line if AJAX validation is needed
		        $this->performAjaxValidation1($model);
		        if(isset($_POST['Docomprat']))
		            {
			$model->attributes=$_POST['Docomprat'];
			//$model->codocu='024'; ///detalle OcompraZACION
			//crietria para filtrar la cantidad de items del detalle
			$criterio=new CDbCriteria;
			 $criterio->condition="hidguia=:nguia  AND idsesion=:idsesionx";
			$criterio->params=array(':nguia'=>$idcabeza,':idsesionx'=>Yii::app()->user->getId());
			$model->item=str_pad(Docomprat::model()->count($criterio)+1,3,"0",STR_PAD_LEFT);
			//str_pad($somevariable,$anchocampo,"0",STR_PAD_LEFT);
			////con esto calculamos el numero de items

			$model->setscenario("solpe");

			if($model->save())
					  if (!empty($_GET['asDialog']))
												{
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialogdetalle').dialog('close');
													                    window.parent.$('#cru-detalle').attr('src','');
																		window.parent.$.fn.yiiGridView.update('detalle-grid');
																		window.parent.$.fn.yiiGridView.update('resumen-grid');
																		");
														Yii::app()->end();
												}
		            }

		 if (!empty($_GET['asDialog']))
		$this->layout = '//layouts/iframe';
		$this->render('_form_detalle_solpe',array(
			'model'=>$model, 'idcabeza'=>$idcabeza
		));

		} else{ //si ya cambio el estado impisble agregar mas items

		   if (!empty($_GET['asDialog']))
		$this->layout = '//layouts/iframe';
		$this->render('vw_imposible',array(

		));
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
		$dataProvider=new CActiveDataProvider('Ocompra');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new VwOcompra('search');
        $model->unsetAttributes();  // clear any default values

		 //$this->performAjaxValifdation($model);
		if(isset($_GET['VwOcompra'])) {
			//EN EL CASO DE QUE SEA UNA BUSQUEDA MEDIANTE EL FOMRUALARIO
			//if ($model->validate()) {
			$model->attributes=$_GET['VwOcompra'];
			//$model->validate();
			$proveedor=$model->search();
			 //  } else {
			  // echo "que carajo";
			  // }
		} else {
		 // $model->validate();
				$proveedor=$model->search2();
		 }

       /* $proveedor = new CActiveDataProvider('VwOcompra', array(
            'sort'=>array(
                'attributes'=>array(
                    'numcot',
                ),
                'defaultOrder' => 'numcot',
            ),
            'pagination' => array(
                'pagesize' => 30,
            ),
        ));*/



		$this->render('admin',array(
			'model'=>$model,'proveedor'=>$proveedor,
		));
	}




public function actionVerdetalle($id)
	{
		$model=new VwOcompra;


		 if (!empty($_GET['asDialog']))
		$this->layout = '//layouts/iframe';
		$this->render('detalleoc',array(
			'model'=>$model, 'id'=>$id
		));

	}


/**
	 * Manages all models.
	 */
	public function actionLibmasiva()
	{
		$model=new VwOcompratotalizado('search');
		$model->unsetAttributes();  // clear any default values

		 //$this->performAjaxValidation($model);
		if(isset($_GET['VwOcompratotalizado'])) {
			//EN EL CASO DE QUE SEA UNA BUSQUEDA MEDIANTE EL FOMRUALARIO
			//if ($model->validate()) {
			$model->attributes=$_GET['VwOcompratotalizado'];
			//$model->validate();s
			$proveedor=$model->search();
			 //  } else {
			  // echo "que carajo";
			  // }
		} else {
		 // $model->validate();
				$proveedor=$model->search();
		 }

		$this->render('liberacionmasiva',array(
			'model'=>$model,'proveedor'=>$proveedor,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Ocompra the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Ocompra::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(500,'No se encontro este documento de compra');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Ocompra $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='Ocompra-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


    public function actionprocesardocumento($id)
    {
        $idevento=(integer)$_GET['ev'];
        $modelo=$this->loadModel((int)$id);
        $evento=VwEventos::model()->find("id=:vid",array(":vid"=>$idevento));
        if(!is_null($evento))
        {
            $cadena="";
            ///Verificanod primero la consistencia del movimieto
            if((trim($modelo->{$this->campoestado})==trim($evento->estadoinicial))){
                $modelo->{$this->campoestado}=$evento->estadofinal;
                $modelo->setScenario('cambiaestado');
                $transaccion=$modelo->dbConnection->beginTransaction();
                if($modelo->save()) {
                    $cadena=$this->proceso($idevento,(int)$id);
                    if($cadena==""){
                        $transaccion->commit();
                        Yii::app()->user->setFlash('success', "El documento se ha procesado cambio de estado ".$evento->einicial."  a  ".$evento->efinal );

                    } else {
                        $transaccion->rollback();
                        Yii::app()->user->setFlash('error', " No se pudo procesar el documento Error: ".$cadena);
                        //$this->render('editadocumento',array('model'=>$modelo));
                        //yii::app()->end();
                    }

                } else {
                    $transaccion->rollback();
                    Yii::app()->user->setFlash('error', "No se pudo cambiar el status");

                }

            } else {
                Yii::app()->user->setFlash('error', " El documento ".$evento->desdocu."   no tiene el status ".$evento->einicial."  No se puede cambiar a ".$evento->efinal);
            }



        } else {
            throw new CHttpException(500,__CLASS__.'   '.__FUNCTION__.'  No se econtro ningun evento con el id {$id}'.$id);
        }
        //$this->render('update',array('model'=>$modelo));
        $this->redirect(array('editadocumento','id'=>$modelo->idguia));

    }




    private function proceso($idevento,$id) {
        $mensaje="";
        switch ($idevento) {
            case 65: ///APROB
                $filas=Ocompra::model()->findByPk($id)->detallefirme;
                foreach($filas as $row ) {
                   // $filafirme=Docompra::model()->findByPk($row->id);//solo si
                    //Solo si no esta anulado
                    IF(!$row->estadodetalle==ESTADO_DOCOMPRA_ANULADO)
                         $row->estadodetalle=ESTADO_DOCOMPRA_APROBADO;

                    ///AVTUALIZAR TAMBIEN EL ESTADO DE LOS REGISTROS DE LA TBLA PUENTE DESOLPECOMPRA

                    //DE ESTO SE ENCARGA DOCOMPRA en el evento AfterSave()

                    if(!$row->save())
                        $mensaje.=" Ocurrió un error  en el item ".$row->item." al guardar los datos del estado detalle  <br>";

                }
                break;

            case 67: ///deshacer APROBACIOPN

                ///AQUI YA NNOS ETRABAJA CON EL BUFFER SE TRABAJADA CON LA TABAL ORIIGNAL
                $filas=Ocompra::model()->findByPk($id)->detallefirme;
                foreach($filas as $row ) {
                    //$filafirme=Docompra::model()->findByPk($row->id);
                   if ( $row->cantidadentregada > 0) {
                       $mensaje.="  El item ".$row->item."  Ya tiene ingreso de almacen <br>";
                   } else { //si no tiene atenciones entonces normal no mas Revertimos

                       $row->setScenario('cambiaestado');
                       $row->estadodetalle=ESTADO_DOCOMPRA_CREADO;
                       $mensaje .= ($row->save()) ? "" : " No se pudo anular el item " . $row->item . "<br>";


                   }
                    //refrescar el buffer
                    $this->ClearBuffer($id); //Limpia temporal
                    $this->IniciaBuffer($id); //Levanta temporales
                }
                break;

            case 66: ///aNULAR
                //aqui hayq ue tabajar directametne cn la tabla firme DOCOMPRA
                $filas=Ocompra::model()->findByPk($id)->detallefirme;
                //aqui hayq ue tabajar directametne cn la tabla firme DOCOMPRA
                foreach($filas as $row ) {

                    if ( $row->cantidadentregada > 0) {
                        $mensaje.="  El item ".$row->item."  Ya tiene ingresos de almacen <br>";
                    } else { //si no tiene atenciones entonces normal no mas Revertimos
                        $row->setScenario('cambiaestado');
                        $row->estadodetalle = ESTADO_DOCOMPRA_ANULADO;
                        $mensaje .= ($row->save()) ? "" : " No se pudo anular el item " . $row->item . "<br>";

                    }
                }
                //refrescar el buffer
                $this->ClearBuffer($id); //Limpia temporal
                $this->IniciaBuffer($id); //Levanta temporales

                break;
        }
        return $mensaje;
    }


	 /** Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation1($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='Solpe-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


    public function actionAgregaimpuesto($idguia){

            $model=new Impuestosdocuaplicado;
         $modelocabeza=$this->loadModel($idguia);
           // $model->setscenario("agregaritemscompra");
           // $this->performAjaxValidation1($model);
            if(isset($_POST['Impuestosdocuaplicado']))
            {
                 $model->setAttributes(array('valorimpuesto'=>Valorimpuestos::getimpuesto ($_POST['Impuestosdocuaplicado']['codimpuesto'] ),'iddocu'=>$modelocabeza->idguia,'codocu'=>$modelocabeza->coddocu,'codimpuesto'=>$_POST['Impuestosdocuaplicado']['codimpuesto']),true);
               if( !$model->save()){
                   print_r($model->geterrors());
                   yii::app()->end();
               }



                if (!empty($_GET['asDialog']))
                {
                    //Close the dialog, reset the iframe and update the grid
                    echo CHtml::script("window.parent.$('#cru-dialogdetalle').dialog('close');
													                    window.parent.$('#cru-detalle').attr('src','');
																		window.parent.$.fn.yiiGridView.update('impuestos-grid');
																		window.parent.$.fn.yiiGridView.update('resumen-grid');
																		");
                    Yii::app()->end();
                }
            }

            if (!empty($_GET['asDialog']))
                $this->layout = '//layouts/iframe';
            //$modeloaux=$modelo
            $this->render('_form_impuesto',array('impuestosyaregistrados'=>$modelocabeza->impuestosaplicados(),
                'modeloimpuesto'=>$model, 'codigodoc'=>$modelocabeza->coddocu,'idcabeza'=>$idguia
            ));








    }

public function actionReporte($id){
    $this->redirect($this->createUrl("coordocs/hacereporte/",array("id"=>8,"idfiltrodocu"=>$id,"file"=>1)));
}

    public function actionenviarpdf($id){
        $model=$this->loadModel((int)MiFactoria::cleanInput($id));
        if(is_file(Yii::getPathOfAlias('webroot').'/assets/'.$this->documento.$id.'_'.yii::app()->user->id.'.pdf'))
        {
        $mensajeerror= yii::app()->correo->correo_adjunto(
                                                Contactos::getListMailContacto($model->idcontacto,$this->documento),
                                                Yii::app()->user->email,
                                                Yii::app()->params['compras_titulomensaje'],
                                                'Este es un correo automatico',
                                                Yii::getPathOfAlias('webroot').'/assets/'.$this->documento.$id.'_'.yii::app()->user->id.'.pdf'
                                                );
            if($mensajeerror=="")
                $this->insertamensaje();


        }else{
           Echo "No se encontro el archivo para enviar" ;
        }
    }


}
