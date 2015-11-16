<?php

/**
 * This is the model class for table "noticias".
 *
 * The followings are the available columns in table 'noticias':
 * @property integer $id
 * @property string $txtnoticia
 * @property string $fecha
 * @property string $autor
 * @property integer $expira
 * @property string $tiponoticia
 * @property string $mensaje
 */
class Noticias extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Noticias the static model class
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
		return 'public_noticias';
	}

	public static function isAdminTablon($iduser=NULL){
		IF(is_null($iduser))
			$iduser=Yii::app()->user->id;

		if($iduser==Confignoticias::model()->findByPk(1)->iduseradm){
			return true;
		} else {
			return false;
		}


	}



	public static function Numeroavisospendientes($iduser=NULL){
		IF(is_null($iduser))
			$iduser=Yii::app()->user->id;

		return count((self::model()->search_usuario_pendientes()->getdata()));


	}


	public static function Numeroavisosporaprobar($iduser=NULL){
		IF(is_null($iduser))
			$iduser=Yii::app()->user->id;

		return count((self::model()->searchporaprobar()->getdata()));


	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('expira', 'numerical', 'integerOnly'=>true),
				array('txtnoticia', 'required', 'message'=>'Llena el mensaje'),
				array('txtnoticia', 'length', 'min'=>20),
				array('tiponoticia', 'required', 'message'=>'Llena el tipo de mensaje'),
			array('autor', 'length', 'max'=>50),
			array('tiponoticia', 'length', 'max'=>2),
			array('mensaje', 'length', 'max'=>1),
			array('txtnoticia', 'safe'),
			array('tiponoticia', 'safe'),
			array('aprobado','safe', 'on'=>'update'),
			array('aprobado','safe', 'on'=>'tratamiento'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id,aprobado, txtnoticia, autor,iduser, fexpira,expira, tiponoticia, mensaje', 'safe', 'on'=>'search'),

			array('tiponoticia', 'required', 'message'=>'Llena el mensaje'),

				array('fechapropuesta', 'required', 'message'=>'Llena la fecha propuesta', 'on'=>'solicita'),
            array('fexpira', 'required', 'message'=>'Llena la fecha de expiracion', 'on'=>'solicita'),





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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'txtnoticia' => 'Txtnoticia',
			'fecha' => 'Fecha',
            'fechapropuesta'=>'Cuando',
			'autor' => 'Autor',
			'fexpira' => 'Expiracion',
			'tiponoticia' => 'Tiponoticia',
			'mensaje' => 'Mensaje',
		);
	}

public function IsOwner($iduser=null){
	IF(is_null($iduser))
		$iduser=Yii::app()->user->id;

	return ($this->autor=Yii::app()->user->name)?true:false;

}

public function beforeSave() {
							if ($this->isNewRecord) {
													if( $this->autor===null or empty( $this->autor))
													if(is_null($this->iduser)){
														$this->autor=Yii::app()->user->name;
														$this->iduser=Yii::app()->user->id;
													}

													$this->fecha=date("Y-m-d H:i:s");
													//if(!($this->expira > 0 ))
														//$this->expira=$this->expira*24*3600;
                                if(is_null($this->aprobado))
									$this->aprobado=0;

												  }

										if($this->aprobado==1 and  ( $this->fechapublicacion===null or empty( $this->fechapublicacion)))
												$this->fechapublicacion=date("Y-m-d H:i:s");


									return parent::beforeSave();
				}

///recolectar correos de todos los usuarios 
				
	
	/**
	 *
	 * Devuelve los avisos vigentes y que stan publoicados en el tablon
	 */
	public function searchtablon()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('txtnoticia',$this->txtnoticia,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('autor',$this->autor,true);
		//$criteria->compare('expira',$this->expira);
		$criteria->compare('tiponoticia',$this->tiponoticia,true);
		$criteria->compare('mensaje',$this->mensaje,true);
         $criteria->addcondition("aprobado=1");
        $criteria->addcondition("fechapropuesta <= '".date('Y-m-d')."'");
        $criteria->addcondition("fexpira >= '".date('Y-m-d')."'");
       //$criteria->addcondition($this->fexpira >= " ".date("Y-m-d")." " );
       // $criteria->addcondition($this->fechapropuesta < strtotime(date("Y-m-d"))+$this->expira );
      // $criteria->addBetweenCondition('fechaent', ''.$this->fechapropuesta.'', ''.$this->fechaent1.'');
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 *
	 * Devuelve todos los avisos deque estan pendientes de aprobacion por usuario
	 */
	public function search_usuario_pendientes()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('txtnoticia',$this->txtnoticia,true);
		$criteria->compare('fecha',$this->fecha,true);
		//$criteria->compare('autor',$this->autor,true);
		//$criteria->compare('expira',$this->expira);
		$criteria->compare('tiponoticia',$this->tiponoticia,true);
		$criteria->compare('mensaje',$this->mensaje,true);
		$criteria->addcondition("aprobado=0","AND");
		$criteria->addcondition("autor=:vautor");
		$criteria->params=Array(":vautor"=>Yii::app()->user->name);
		//$criteria->addcondition("fechapropuesta <= '".date('Y-m-d')."'");
		//$criteria->addcondition("fexpira >= '".date('Y-m-d')."'");
		//$criteria->addcondition($this->fexpira >= " ".date("Y-m-d")." " );
		// $criteria->addcondition($this->fechapropuesta < strtotime(date("Y-m-d"))+$this->expira );
		// $criteria->addBetweenCondition('fechaent', ''.$this->fechapropuesta.'', ''.$this->fechaent1.'');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public function search_loquedebever()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('txtnoticia',$this->txtnoticia,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('autor',$this->autor,true);
		$criteria->compare('expira',$this->expira);
		$criteria->compare('tiponoticia',$this->tiponoticia,true);
		$criteria->compare('mensaje',$this->mensaje,true);
		$criteria->addcondition("aprobado=1 "," OR ");
		$criteria->addcondition("autor='".Yii::app()->user->name."'");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	/**
	 *
	 * Devuelve TODOS LOS AVISOS
	 */
	public function searchsolicitados()
	{

		$criteria=new CDbCriteria;

		//$criteria->compare('id',$this->id);
		$criteria->compare('txtnoticia',$this->txtnoticia,true);
		$criteria->compare('fecha',$this->fecha,true);
		//$criteria->compare('autor',$this->autor,true);
		//$criteria->compare('expira',$this->expira);
		$criteria->compare('tiponoticia',$this->tiponoticia,true);
		$criteria->compare('mensaje',$this->mensaje,true);
		//$criteria->addcondition("aprobado=1");
		//$criteria->addcondition("fechapropuesta <= '".date('Y-m-d')."'");
		//$criteria->addcondition("fexpira >= '".date('Y-m-d')."'");
		//$criteria->addcondition($this->fexpira >= " ".date("Y-m-d")." " );
		// $criteria->addcondition($this->fechapropuesta < strtotime(date("Y-m-d"))+$this->expira );
		// $criteria->addBetweenCondition('fechaent', ''.$this->fechapropuesta.'', ''.$this->fechaent1.'');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	/**
	 *
	 * Devuelve TODOS LOS AVISOS QUE HAN SIDO APROBADOS
	 */
	public function searchaprobados()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('txtnoticia',$this->txtnoticia,true);
		$criteria->compare('fecha',$this->fecha,true);
		//$criteria->compare('autor',$this->autor,true);
		//$criteria->compare('expira',$this->expira);
		$criteria->compare('tiponoticia',$this->tiponoticia,true);
		$criteria->compare('mensaje',$this->mensaje,true);
		$criteria->addcondition("aprobado=1");
		//$criteria->addcondition("fechapropuesta <= '".date('Y-m-d')."'");
		//$criteria->addcondition("fexpira >= '".date('Y-m-d')."'");
		//$criteria->addcondition($this->fexpira >= " ".date("Y-m-d")." " );
		// $criteria->addcondition($this->fechapropuesta < strtotime(date("Y-m-d"))+$this->expira );
		// $criteria->addBetweenCondition('fechaent', ''.$this->fechapropuesta.'', ''.$this->fechaent1.'');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}



	/**
	 *
	 * Devuelve TODOS LOS AVISOS QUE HAN SIDO APROBADOS
	 */
	public function searchporaprobar()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('txtnoticia',$this->txtnoticia,true);
		$criteria->compare('fecha',$this->fecha,true);
		//$criteria->compare('autor',$this->autor,true);
		//$criteria->compare('expira',$this->expira);
		$criteria->compare('tiponoticia',$this->tiponoticia,true);
		$criteria->compare('mensaje',$this->mensaje,true);
		$criteria->addcondition("aprobado=0");
		//$criteria->addcondition("fechapropuesta <= '".date('Y-m-d')."'");
		//$criteria->addcondition("fexpira >= '".date('Y-m-d')."'");
		//$criteria->addcondition($this->fexpira >= " ".date("Y-m-d")." " );
		// $criteria->addcondition($this->fechapropuesta < strtotime(date("Y-m-d"))+$this->expira );
		// $criteria->addBetweenCondition('fechaent', ''.$this->fechapropuesta.'', ''.$this->fechaent1.'');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}





	public function searchuser()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('txtnoticia',$this->txtnoticia,true);
        $criteria->compare('fecha',$this->fecha,true);
        $criteria->compare('autor',$this->autor,true);
        $criteria->compare('expira',$this->expira);
        $criteria->compare('tiponoticia',$this->tiponoticia,true);
        $criteria->compare('mensaje',$this->mensaje,true);
        $criteria->addcondition("aprobado=0 ");
        $criteria->addcondition("autor='".Yii::app()->user->name."'");
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }



}