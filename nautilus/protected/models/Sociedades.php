<?php

/**
 * This is the model class for table "sociedades".
 *
 * The followings are the available columns in table 'sociedades':
 * @property string $socio
 * @property string $dsocio
 * @property string $rucsoc
 * @property string $creadopor
 * @property string $creadoel
 * @property string $modificadopor
 * @property string $modificadoel
 * @property integer $estado
 */
class Sociedades extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Sociedades the static model class
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
		return 'public_sociedades';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes thatA
		// will receive user inputs.gatorio
		return array(
			array('socio, dsocio,activo, rucsoc', 'required','message'=>'Dato obligatorio'),
			array('rucsoc',  'match', 'pattern'=> '/[0-9]{11}/', 'message'=>'Es un valor incorrecto de RUC'),
			array('rucsoc',  'unique', 'message'=>'Este valor ya ha sido tomado'),
			//array('socio', 'integerOnly'=>true),
			array('estado', 'numerical', 'integerOnly'=>true),
			array('socio', 'length', 'max'=>1),
			array('dsocio', 'length', 'max'=>40),
			array('rucsoc', 'length', 'max'=>11),
			array('socio, dsocio, rucsoc,direccionfiscal,telefono,web, estado', 'safe', 'on'=>'insert,update'),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('socio, dsocio, rucsoc, creadopor, creadoel, modificadopor, modificadoel, estado', 'safe', 'on'=>'search'),
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

	public  function proveedor(){
		return Clipro::model()->find("rucpro=:vrucpro",array(":vrucpro"=>$this->rucsoc));
	}

public function beforeSave() {
							if ($this->isNewRecord) {
									
									  $this->estado=1;
											//$this->c_salida='1';
									} else
									{
										
										//$this->ultimares=" ".strtoupper(trim($this->usuario=Yii::app()->user->name))." ".date("H:i")." :".$this->ultimares;
									}
									return parent::beforeSave();
				}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'socio' => 'Cod. Socio',
			'dsocio' => 'Nombre ',
			'rucsoc' => 'RUC',
			/*'creadopor' => 'Creadopor',
			'creadoel' => 'Creadoel',
			'modificadopor' => 'Modificadopor',
			'modificadoel' => 'Modificadoel',
			'estado' => 'Estado',*/
		);
	}


	public static function isActive($id){
		if(is_null(self::model()->findByPk($id))){

			throw new CHttpException(500,__CLASS__.' => '.__FUNCTION__.'  '.__LINE__.'   No se encontro el registro socio.');
		}else{
			return (self::model()->findByPk($id)->activo=='1')?true:false;
		}

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

		$criteria->compare('socio',$this->socio,true);
		$criteria->compare('dsocio',$this->dsocio,true);
		$criteria->compare('rucsoc',$this->rucsoc,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}