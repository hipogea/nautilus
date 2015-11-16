<?php

/**
 * This is the model class for table "alreserva".
 *
 * The followings are the available columns in table 'alreserva':
 * @property integer $id
 * @property string $hidesolpe
 * @property string $estadoreserva
 * @property string $fechares
 * @property string $usuario
 * @property double $cant
 * @property string $codocu
 * @property integer $numreserva
 * @property string $flag
 *
 * The followings are the available model relations:
 * @property Desolpe $hidesolpe0
 */
class Alreserva extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Alreserva the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    //ok


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->params['prefijo'].'alreserva';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cant', 'numerical'),
			array('estadoreserva', 'length', 'max'=>2),
			array('usuario', 'length', 'max'=>25),
			array('codocu', 'length', 'max'=>3),
			array('flag', 'length', 'max'=>1),
			array('hidesolpe, ,rex,fechares', 'safe'),





			array('estadoreserva','safe', 'on'=> 'cambiaestado'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, hidesolpe, estadoreserva, fechares, usuario, cant, codocu, numreserva, flag', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'desolpe' => array(self::BELONGS_TO, 'Desolpe', 'hidesolpe'),
			  'alreserva_estado'=>array(self::BELONGS_TO,'Estado',array('estadoreserva'=>'codestado','codocu'=>'codocu')),
			   'alreserva_documentos'=>array(self::BELONGS_TO,'Documentos','codocu'),
			//'alreserva_kardex'=>array(self::STAT,'Alkardex','codocu'),
			//'alreserva_numereservasatendidas'=>array(self::STAT, 'Atencionreserva', 'hidreserva','condition'=>"estadoatencion='01'"),//el campo foraneo
			'alreserva_cantidadatendida'=>array(self::STAT, 'Atencionreserva', 'hidreserva','select'=>'sum(cant)','condition'=>"estadoatencion='10'"),//el campo foraneo
			//'numerocompras'=>array(self::STAT, 'Desolpecompra', 'iddesolpe'),//el campo foraneo
			//'solpe_totalreal'=>array(self::STAT,'Desolpe','hidsolpe','select'=>'sum(punitreal*cant)','condition'=>"est <> '02' "),//el subtotal del planeado

		);
	}

	public function sepuedeanular(){
		return($this->alreserva_cantidadatendida ==0)?true:false;

	}

	public function cantidadbase(){
		return ($this->desolpe->um <> $this->desolpe->maestro->um)?$this->cant*Alconversiones::convierte($this->desolpe->codart,$this->desolpe->maestro->um):$this->cant;

	}


	public function anular(){
		$retorno=false;
		$mensaje="";
		if($this->sepuedeanular()){
			IF($this->codocu=='450')
			{
				//verifica el stock
				if($this->desolpe->desolpe_alinventario->stockreserva_a_libre($this->cantidadbase()))
				{
					$this->desolpe->desolpe_alinventario->setScenario(Alinventario::ESCENARIO_ACTUALIZARSTOCK);
					if(!$this->desolpe->desolpe_alinventario->save())
							{
						     			//Yii::app()->user->setFlash('error', "La reserva del item  ".$this->desolpe->item."  del material ".$this->desolpe->txtmaterial." No se pudo anular porque no se grabo el registro del inventario ");
					        			$mensaje.= "La reserva del item  ".$this->desolpe->item."  del material ".$this->desolpe->txtmaterial." No se pudo anular porque no se grabo el registro del inventario<br> ";
							} else{
						           		$retorno=true;
										//$mensaje.= "La reserva del item  ".$this->desolpe->item."  del material ".$this->desolpe->txtmaterial." No se pudo anular porque no se grabo el registro del inventario<br> ";

						//Yii::app()->user->setFlash('success', "La reserva del item  ".$this->desolpe->item."  del material ".$this->desolpe->txtmaterial." Se ha anulado ");

							}
				}else{
					$retorno=false;
					$mensaje.= "No se puede anular esta reserva no existe suficiente stock reservado para liberar <br>";

				}

			}



			IF($this->codocu=='800')
			{
				//verifica que no tenga ninguna SOLPE DE COMRPAS QUE hace referfncia a esta reserba
				$gg=Desolpe::model()->find("idreserva=:vidreserva",array(":vidreserva"=>$this->id));
				if(!is_null($gg))
					if($gg->est!='20')
						$mensaje.=" Esta reserva no se puede anular ya tiene como referencia a la Solicitud de compra ".$gg->desolpe_solpe->numero."   Item ".$gg->item."<br>";



			}


		} else
		{
			$mensaje.= "La reserva del item  ".$this->desolpe->item."  del material ".$this->desolpe->txtmaterial." Ya tiene atenciones<br> ";

					//Yii::app()->user->setFlash('error', "La reserva del item  ".$this->desolpe->item."  del material ".$this->desolpe->txtmaterial." Ya tiene atenciones ");
		}
		if(trim($mensaje)==""){
			$this->estadoreserva='30';
			$this->save();
		}
		return $mensaje;
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'hidesolpe' => 'Hidesolpe',
			'estadoreserva' => 'Estadoreserva',
			'fechares' => 'Fechares',
			'usuario' => 'Usuario',
			'cant' => 'Cant',
			'codocu' => 'Codocu',
			'numreserva' => 'Numreserva',
			'flag' => 'Flag',
		);
	}
public $maximovalor;
	//public $conservarvalor=0; //Opcionpa reaverificar si se quedan lo valores predfindos en sesiones 

public function beforeSave() {
							if ($this->isNewRecord) {
												if($this->flag=='1')
													$this->codocu='450'; //reserva
											    if($this->flag=='0')
													$this->codocu='800'; //solciituyd de compra
												$this->fechares=date("Y-m-d H:i:s"); 
												$this->usuario=Yii::app()->user->name;											
											$this->estadoreserva='10';
											
									} else
									{

										  }


									

									return parent::beforeSave();
				}
	





	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('hidesolpe',$this->hidesolpe,true);
		$criteria->compare('estadoreserva',$this->estadoreserva,true);
		$criteria->compare('fechares',$this->fechares,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('cant',$this->cant);
		$criteria->compare('codocu',$this->codocu,true);
		$criteria->compare('numreserva',$this->numreserva);
		$criteria->compare('flag',$this->flag,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


    public function search_por_codigo($codigo)
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('hidesolpe',$this->hidesolpe,true);
        $criteria->compare('estadoreserva',$this->estadoreserva,true);
        $criteria->compare('fechares',$this->fechares,true);
        $criteria->compare('usuario',$this->usuario,true);
        $criteria->compare('cant',$this->cant);
        $criteria->compare('codocu',$this->codocu,true);
        $criteria->compare('numreserva',$this->numreserva);
        $criteria->compare('flag',$this->flag,true);
        $criteria->addcondition("");

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

	public function search_idsolpe($idcabecera)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('hidesolpe',$this->hidesolpe,true);
		$criteria->compare('estadoreserva',$this->estadoreserva,true);
		$criteria->compare('fechares',$this->fechares,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('cant',$this->cant);
		$criteria->compare('codocu',$this->codocu,true);
		$criteria->compare('numreserva',$this->numreserva);
		$criteria->compare('flag',$this->flag,true);
		$criteria->addcondition("hidesolpe=".$idcabecera);
		//$criteria->addcondition("estadoreserva='01'");

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}