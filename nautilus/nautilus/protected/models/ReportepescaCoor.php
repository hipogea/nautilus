<?php

/**
 * This is the model class for table "reportepesca_coor".
 *
 * The followings are the available columns in table 'reportepesca_coor':
 * @property string $id
 * @property string $hidreporte
 * @property string $latitud
 * @property string $meridiano
 * @property string $aliaszona
 *
 * The followings are the available model relations:
 * @property Reportepesca $hidreporte0
 */
class ReportepescaCoor extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ReportepescaCoor the static model class
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
		return 'reportepesca_coor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('id', 'required'),
			array('latitud, meridiano', 'length', 'max'=>5),
			array('aliaszona', 'length', 'max'=>25),
			array('hidreporte', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array(' hidreporte, latitud, meridiano, aliaszona', 'safe', 'on'=>'search'),
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
			'hidreporte0' => array(self::BELONGS_TO, 'Reportepesca', 'hidreporte'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			//'id' => 'ID',
			'hidreporte' => 'Hidreporte',
			'latitud' => 'Latitud',
			'meridiano' => 'Meridiano',
			'aliaszona' => 'Aliaszona',
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

		//$criteria->compare('id',$this->id,true);
		$criteria->compare('hidreporte',$this->hidreporte,true);
		$criteria->compare('latitud',$this->latitud,true);
		$criteria->compare('meridiano',$this->meridiano,true);
		$criteria->compare('aliaszona',$this->aliaszona,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}