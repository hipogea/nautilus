<?php

/**
 * This is the model class for table "{{impuestosdocu}}".
 *
 * The followings are the available columns in table '{{impuestosdocu}}':
 * @property integer $id
 * @property string $codocu
 * @property string $codimpuesto
 *
 * The followings are the available model relations:
 * @property Impuestos $codimpuesto0
 * @property Documentos $codocu0
 */
class Impuestosdocu extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{impuestosdocu}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codocu, codimpuesto', 'required'),
			array('obligatorio,codimpuesto, codocu', 'safe'),
			array('codocu, codimpuesto', 'length', 'max'=>3),
			array('codocu+codimpuesto','application.extensions.uniqueMultiColumnValidator','on'=>'insert'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, codocu, codimpuesto', 'safe', 'on'=>'search'),
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
			'impuestos' => array(self::BELONGS_TO, 'Impuestos', 'codimpuesto'),
			'documentos' => array(self::BELONGS_TO, 'Documentos', 'codocu'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
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
		$criteria->compare('codocu',$this->codocu,true);
		$criteria->compare('codimpuesto',$this->codimpuesto,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Impuestosdocu the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
