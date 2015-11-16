<?php

/**
 * This is the model class for table "cruge_grupos_mail".
 *
 * The followings are the available columns in table 'cruge_grupos_mail':
 * @property integer $id
 * @property string $desgrupo
 * @property string $deslarga
 */
class CrugeGruposMail extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CrugeGruposMail the static model class
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
		return 'cruge_grupos_mail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('desgrupo', 'length', 'max'=>30),
			array('deslarga', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, desgrupo, deslarga', 'safe', 'on'=>'search'),
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
			'desgrupo' => 'Desgrupo',
			'deslarga' => 'Deslarga',
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
		$criteria->compare('desgrupo',$this->desgrupo,true);
		$criteria->compare('deslarga',$this->deslarga,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}