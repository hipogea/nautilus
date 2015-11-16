<?php

/**
 * This is the model class for table "maestroclipro".
 *
 * The followings are the available columns in table 'maestroclipro':
 * @property integer $id
 * @property string $codart
 * @property string $codpro
 * @property string $codmon
 * @property double $precio
 *
 * The followings are the available model relations:
 * @property Maestrocomponentes $codart0
 * @property Clipro $codpro0
 */
class Maestroclipro extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Maestroclipro the static model class
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
		return 'public_maestroclipro';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('precio', 'numerical'),
			array('codart', 'length', 'max'=>8),
			array('codart', 'checkvalores', 'on'=>'insert,update'),
			array('codart', 'required', 'message'=>'Ingresa el Material'),
			array('centro', 'required', 'message'=>'Ingresa el centro'),
			array('um', 'required','message'=>'Ingresa la unidad'),
			array('um', 'checkum', 'on'=>'insert,update'),
			array('codpro', 'required', 'message'=>'Ingresa el Proveedor'),
			array('codmon', 'required', 'message'=>'Ingresa la moneda'),
			array('codmon', 'length', 'max'=>3),
			array('codpro+codart+um+centro', 'application.extensions.uniqueMultiColumnValidator','on'=>'insert'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, codart, codpro, codmon,um, precio', 'safe', 'on'=>'search'),
		);
	}



	public function checkvalores($attribute,$params) {

					$modeloco=Maestrocompo::model()->findByPk($this->codart);
					if($modeloco===null)
						 $this->adderror('codart','Este material no existe' );

							}
					

							
     public function checkum($attribute,$params) {
				$modeloum=Alconversiones::model()->findAll("codart='".$this->codart."' and um2 ='".$this->um."'");
				if(!$modeloum===null) { //si hay registros  ok


				} else { //si no hay  registros ver que se al unida de medida base sino error
					$maestro=Maestrocompo::model()->findByPk($this->codart);
					if($maestro===null) {
						$this->adderror('codart','Este material no existe' );
						  }else {
						  		if($maestro->um<>$this->um)
						  			$this->adderror('um','Esta unidad de medida no esta ampliada para este material,amplie las vistas del material' );

						  }
					 


				}
					
					

							}

	/**




	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'maestroclipro_maestrocompo' => array(self::BELONGS_TO, 'Maestrocompo', 'codart'),
			'maestroclipro_clipro' => array(self::BELONGS_TO, 'Clipro', 'codpro'),
			'maestroclipro_centros' => array(self::BELONGS_TO, 'Centros', 'centro'),
			'ofertas' => array(self::HAS_MANY, 'Ofertas', 'hidamaestroclipro'),
			'ofertas_pendientes' => array(self::STAT, 'Ofertas', 'hidmaestroclipro','condition'=>"tratado <> '1'"),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'codart' => 'Codart',
			'codpro' => 'Codpro',
			'codmon' => 'Codmon',
			'precio' => 'Precio',
			'um' => 'Um',
			'centro'=>'Centro',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('codart',$this->codart,true);
		$criteria->compare('codpro',$this->codpro,true);
		$criteria->compare('codmon',$this->codmon,true);
		$criteria->compare('precio',$this->precio);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function search_codigo($codpro)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('codart',$this->codart,true);
		$criteria->compare('codpro',$this->codpro,true);
		$criteria->compare('codmon',$this->codmon,true);
		$criteria->compare('precio',$this->precio);
		$criteria->addcondition("codpro='".$codpro."'");

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}