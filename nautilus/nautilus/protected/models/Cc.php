<?php

/**
 * This is the model class for table "cc".
 *
 * The followings are the available columns in table 'cc':
 * @property string $idcc
 * @property string $codc
 * @property string $cc
 * @property string $centro
 * @property string $creadopor
 * @property string $creadoel
 * @property string $modificadopor
 * @property string $modificadoel
 */
class Cc extends CActiveRecord implements IColectores
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Cc the static model class
	 */



    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{cc}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('codc', 'required','message'=>'Tiene que indicar el centro de costo'),
			array('correlativo', 'required', 'message'=>'Llene este dato','on'=>'insert'),
			array('correlativo', 'numerical', 'integerOnly'=>true),
			/*array('codc', 'length', 'max'=>12),
			array('codc', 'required'),
			array('codc', 'length', 'min'=>4),*/
			array('codc', 'unique', 'on'=>'insert,update'),
			array('codgrupo', 'required'),
			array('codc', 'match', 'pattern'=>Yii::app()->params['mascaraceco'],'message'=>'El codigo del Ceco no es valido, caracteres deben ser numericos '),
			array('desceco', 'required','message'=>'Indique una descricpion'),
			array('centro', 'required','message'=>'Llene el centro'),
			array('validodel', 'required','message'=>'Llene el inicio de vigencia'),	
			array('validoal', 'required','message'=>'Llene el final de vigencia'),	
			array('codc, cc, validodel, validoal,centro, vale,creadopor,desceco,correlativo, codclase,creadoel, modificadopor, modificadoel,explicacion','safe','on'=>'insert,update'),
			array('centro', 'length', 'max'=>4),
			array('creadopor, modificadopor', 'length', 'max'=>25),
			array('creadoel, modificadoel', 'length', 'max'=>20),
			array('semaforopresup','required','message'=>'Indique si es posible presupuesto'),
			array('codc, cc, centro, vale,validoel,validoal', 'safe', 'on'=>'search'),
			array('clasecolector', 'safe'),
			array('codc, cc, centro, clasecolector,vale,creadopor,desceco, creadoel, modificadopor, modificadoel', 'safe', 'on'=>'search'),
		);
	}

	public function valefecha ($fecha) {
	  
		$tiempoinicio=strtotime($this->validodel);
		$tiempofinal=strtotime($this->validoal);
		$tiempoactual=strtotime($fecha);
		
		return ($tiempoactual  > $tiempofinal or $tiempoactual  < $tiempoinicio) ?false:true;
		
	}

	public static function Insertamonto($idkardex) {
		MiFactoria::InsertaCcGastos($idkardex);
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'gastos' => array(self::HAS_MANY, 'CcGastos', 'ceco'),
			'numerogastos'=>array(self::STAT, 'CcGastos', 'ceco'),

		             );
	}

Public function Verificafecha($fecha) {
	//VERIFICA QUE LA FECHA ESTE DENTRO DEL RANGO DE VALDEZ;
	$tiempoinicio =  strtotime($this->validodel);
	$tiempofinal =  strtotime($this->validoal);
	$tiempoactual=strtotime($fecha);

     return ($tiempoactual <= $tiempofinal  and $tiempoactual >= $tiempoinicio)?true:false;

}

public function tienegastos(){
	return  ($this->numerogastos > 0)?true:false;
}


	Public function Verificaesposible() {
		//VERIFICA QUE SE PUEDA IMPUTAR O A LO MEJOR YA ESTA CERRADO;
		return ($this->semaforopresup=='1')?true:false;

	}

	Public function Verificacentro($centro) {
		//VERIFICA QUE SE PUEDA IMPUTAR a un mismo centro;
		return ($this->centro==$centro)?true:false;

	}



	public $maximovalor;
	//public $conservarvalor=0; //Opcionpa reaverificar si se quedan lo valores predfindos en sesiones 
	public function beforeSave() {
							if ($this->isNewRecord) {
									   
										$this->codc=$this->codclase.$this->codgrupo.str_pad(trim($this->correlativo),4,"0",STR_PAD_LEFT);
										$this->creadopor=Yii::app()->user->name;
								//$this->clasecolector='K';
										//$this->coddoc='046';
										//$this->codestado='99';
										
												$this->creadoel=date("Y-m-d H:i:s"); 
												
								    
									} else
									{
										
										}

										
										
									return parent::beforeSave();
				}
	
	




	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			//'idcc' => 'Idcc',
			'codc' => 'Codc',
			'correlativo' => 'Colector',
			'cc' => 'Cc',
			'centro' => 'Centro',
			'creadopor' => 'Creadopor',
			'creadoel' => 'Creadoel',
			'modificadopor' => 'Modificadopor',
			'modificadoel' => 'Modificadoel',
			'semaforopresup' => 'Abierto',
		);
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

		//$criteria->compare('idcc',$this->idcc,true);
		$criteria->compare('codc',$this->codc,true);
		$criteria->compare('cc',$this->cc,true);
		$criteria->compare('centro',$this->centro,true);
		$criteria->compare('clasecolector',$this->clasecolector,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function esvalidocolector($imputacion)
    {
        $registro=self::model()->findByPk($imputacion);
        $mensaje="";
        //verificando primero si esta habilitado
        if(!yii::app()->periodo->HoyDentroDe($registro->validodel,$registro->validoal))
            $mensaje.="  Este colector no esta habilitado para la fecha actual, verifique los datos maestros  <br>";

        //si el semaforo presupuestal esta  activado y es un ceco
        if(!$registro->semaforopresup=='1')
            $mensaje.="  Este colector ha sido temporalmente deshabilitado por gestion de presupuesto <br>";

   return $mensaje;


    }
}