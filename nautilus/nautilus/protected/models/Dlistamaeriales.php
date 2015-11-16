<?php

/**
 * This is the model class for table "{{dlistamaeriales}}".
 *
 * The followings are the available columns in table '{{dlistamaeriales}}':
 * @property string $id
 * @property string $hidlista
 * @property string $codigo
 */
class Dlistamaeriales extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{dlistamaeriales}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hidlista, codigo', 'required'),
			array('hidlista', 'length', 'max'=>20),
			array('codigo', 'length', 'max'=>10),
			array('codigo', 'exist','allowEmpty'=>false,'attributeName'=>'codigo','className'=>'Maestrocompo','message'=>'Este código no existe'),
			array('codigo+hidlista', 'application.extensions.uniqueMultiColumnValidator'),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, hidlista, codigo,um,tipsolpe,cant', 'safe'),
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
			'ums'=>array(self::BELONGS_TO, 'Ums', 'um'),
			'maestro'=>array(self::BELONGS_TO, 'Maestrocompo', 'codigo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'hidlista' => 'Hidlista',
			'codigo' => 'Codigo',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('hidlista',$this->hidlista,true);
		$criteria->compare('codigo',$this->codigo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public function search_por_lista($hid)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
          $hid=(int)$hid;
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('hidlista',$this->hidlista,true);
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->addcondition(" hidlista=".$hid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Dlistamaeriales the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
