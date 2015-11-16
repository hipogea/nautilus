<?php

/**
 * This is the model class for table "mot_materiales".
 *
 * The followings are the available columns in table 'mot_materiales':
 * @property string $fecha
 * @property integer $id
 * @property string $descripcion
 * @property string $numero
 * @property string $codcentro
 * @property string $codplanta
 * @property string $codtraba
 * @property string $creadoel
 * @property string $creadopor
 * @property string $modificadoel
 * @property string $modificadopor
 * @property string $codep
 *
 * The followings are the available model relations:
 * @property Plantas $codplanta0
 * @property Trabajadores $codtraba0
 * @property Embarcaciones $codep0
 * @property MotMatDet[] $motMatDets
 */
class Mot extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Mot the static model class
	 */
	 
   public $maximovalor;
   public $numeroauxiliar;
   public $barquitos_nomep;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mot_materiales';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('descripcion, creadoel, modificadoel', 'length', 'max'=>25),
			array('codep','required','message'=>'Debes de indicar la embarcacion'),
			array('descripcion','required','message'=>'Indica algo'),
			array('codcentro','required','message'=>'Donde estas localizado?'),
			array('fecha','required','message'=>'Llena la fecha '),
			array('numero', 'length', 'max'=>11),
			array('codcentro, codep', 'length', 'max'=>4),
			array('codplanta', 'length', 'max'=>2),
			array('codtraba', 'length', 'max'=>4),
			array('creadopor', 'length', 'max'=>20),
			array('fecha,barquitos.nomep,modificadopor,numeroauxiliar', 'safe'),
			//array('numeroauxiliar', 
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('fecha,numeroauxiliar, id, descripcion, numero, codcentro, codplanta, codtraba, creadoel, creadopor, modificadoel, modificadopor, codep', 'safe', 'on'=>'search'),
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
			'codplanta0' => array(self::BELONGS_TO, 'Plantas', 'codplanta'),
			'codtraba0' => array(self::BELONGS_TO, 'Trabajadores', 'codtraba'),
			'barquitos' => array(self::BELONGS_TO, 'Embarcaciones', 'codep'),
			'motMatDets' => array(self::HAS_MANY, 'MotMatDet', 'hidmot'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'fecha' => 'Fecha',
			'id' => 'ID',
			'descripcion' => 'Descripcion',
			'numero' => 'Numero',
			'codcentro' => 'Codcentro',
			'codplanta' => 'Codplanta',
			'codtraba' => 'Codtraba',
			'creadoel' => 'Creadoel',
			'creadopor' => 'Creadopor',
			'modificadoel' => 'Modificadoel',
			'modificadopor' => 'Modificadopor',
			'codep' => 'Codep',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	
	
	
	
	public function beforeSave() {
							if ($this->isNewRecord) {
									//$this->created = new CDbExpression('NOW()');
									// $nuevovalor=new CDbExpression('SELEC MAX(NUMERO)');
										//$this->numero=new CDbExpression('SELECt MAX(NUMERO) from mot_materiales');
									//$this->modified = new CDbExpression('NOW()');
									 $this->numero=Numeromaximo::numero($this,'numero','maximovalor',11);
									$this->codtraba='0001';
									//$this->creadorpor='0001';

									}
									return parent::beforeSave();
				}
	
	
	
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('id',$this->id);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('numero',$this->numero,true);
		$criteria->compare('codcentro',$this->codcentro,true);
		$criteria->compare('codplanta',$this->codplanta,true);
		$criteria->compare('codtraba',$this->codtraba,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('codep',$this->codep,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}