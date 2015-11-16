<?php

/**
 * This is the model class for table "{{impuestosdocuaplicado}}".
 *
 * The followings are the available columns in table '{{impuestosdocuaplicado}}':
 * @property integer $id
 * @property string $iddocu
 * @property integer $codocu
 * @property string $codimpuesto
 */
class Impuestosdocuaplicado extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{impuestosdocuaplicado}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('iddocu, codocu, codimpuesto', 'required'),
			array('codocu', 'numerical', 'integerOnly'=>true),
			array('iddocu', 'length', 'max'=>20),
			array('valorimpuesto','safe', 'on'=>'insert,update'),
			array('codimpuesto', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, iddocu, codocu, codimpuesto', 'safe', 'on'=>'search'),
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
		  'documento' => array(self::BELONGS_TO, 'Documentos', array('codocu'=>'coddocu') ),
		   'impuesto' => array(self::BELONGS_TO, 'Impuestos', array('codimpuesto'=>'codimpuesto') ),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'iddocu' => 'Iddocu',
			'codocu' => 'Codocu',
			'codimpuesto' => 'Codimpuesto',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('iddocu',$this->iddocu,true);
		$criteria->compare('codocu',$this->codocu);
		$criteria->compare('codimpuesto',$this->codimpuesto,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function search_por_id($id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		$criteria=new CDbCriteria;
		$criteria->compare('iddocu',$this->iddocu,true);
		$criteria->compare('codocu',$this->codocu);
		$criteria->compare('codimpuesto',$this->codimpuesto,true);
		$criteria->addcondition("iddocu=".(int)$id);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Impuestosdocuaplicado the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
