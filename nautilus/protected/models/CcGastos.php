<?php

/**
 * This is the model class for table "ccgastos".
 *
 * The followings are the available columns in table 'ccgastos':
 * @property integer $id
 * @property string $ceco
 * @property string $fechacontable
 * @property double $monto
 * @property string $codmoneda
 * @property string $usuario
 * @property string $idref
 * @property string $tipo
 *
 * The followings are the available model relations:
 * @property Cc $ceco0
 */
class CcGastos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CcGastos the static model class
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
		return Yii::app()->params['prefijo'].'ccgastos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('monto', 'numerical'),
			array('ceco', 'length', 'max'=>12),
			array('codmoneda', 'length', 'max'=>3),
			array('usuario', 'length', 'max'=>25),
			array('tipo', 'length', 'max'=>1),
			array('fechacontable,ano,mes,clasecolector, idref', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ceco, fechacontable, monto, codmoneda, usuario, idref, tipo', 'safe', 'on'=>'search'),
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
			'ceco0' => array(self::BELONGS_TO, 'Cc', 'ceco'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ceco' => 'Ceco',
			'fechacontable' => 'Fechacontable',
			'monto' => 'Monto',
			'codmoneda' => 'Codmoneda',
			'usuario' => 'Usuario',
			'idref' => 'Idref',
			'tipo' => 'Tipo',
		);
	}
	
	public function Clonaregistro()  {
		if(!$this->isNewRecord)	 {
			$nuevoregistro=New CcGastos();
		    $nuevoregistro->attributes=$this->attributes;
		   Return $nuevoregistro;
		} ELSE  {
			 RETURN NULL;
		}

	}
	
	//public $conservarvalor=0; //Opcionpa reaverificar si se quedan lo valores predfindos en sesiones 
	public function beforeSave() {
							if ($this->isNewRecord) {
										$this->usuario=Yii::app()->user->name;
										$this->creadoel=date("Y-m-d H:i:s");
								        $this->iduser=Yii::app()->user->id;
										$this->mes=substr($this->fechacontable,5,2);
										$this->ano=substr($this->fechacontable,0,4);
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
		$criteria->compare('ceco',$this->ceco,true);
		$criteria->compare('fechacontable',$this->fechacontable,true);
		$criteria->compare('monto',$this->monto);
		$criteria->compare('codmoneda',$this->codmoneda,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('idref',$this->idref,true);
		$criteria->compare('tipo',$this->tipo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}