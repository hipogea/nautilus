<?php

/**
 * This is the model class for table "{{confignoticias}}".
 *
 * The followings are the available columns in table '{{confignoticias}}':
 * @property integer $id
 * @property integer $iduseradm
 * @property integer $column_3
 */
class Confignoticias extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{confignoticias}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('iduseradm, column_3', 'required'),
			array('iduseradm, column_3', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, iduseradm, column_3', 'safe', 'on'=>'search'),
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

//Obtiene el correo del patin que admsntra e tablon
	public static function getMailAdminTablon() {
		//obtner el correo del
		return Yii::app()->user->um->loadUserById(self::model()->findByPk(1)->id)->email;


	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'iduseradm' => ' Establecer como administrador a : ',
			'column_3' => 'Column 3',
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
		$criteria->compare('iduseradm',$this->iduseradm);
		$criteria->compare('column_3',$this->column_3);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Confignoticias the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
