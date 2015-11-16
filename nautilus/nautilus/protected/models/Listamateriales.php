<?php

/**
 * This is the model class for table "{{listamateriales}}".
 *
 * The followings are the available columns in table '{{listamateriales}}':
 * @property string $id
 * @property string $nombrelista
 * @property string $comentario
 * @property integer $iduser
 * @property string $compartida
 */
class Listamateriales extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{listamateriales}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombrelista, comentario, compartida', 'required'),
			array('iduser', 'numerical', 'integerOnly'=>true),
			array('nombrelista', 'length', 'max'=>60),
			array('compartida', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombrelista, comentario, iduser, compartida', 'safe', 'on'=>'search'),
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

			'hijos'=> array(self::HAS_MANY, 'Dlistamaeriales', 'hidlista'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombrelista' => 'Nombrelista',
			'comentario' => 'Comentario',
			'iduser' => 'Iduser',
			'compartida' => 'Compartida',
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
		$criteria->compare('nombrelista',$this->nombrelista,true);
		$criteria->compare('comentario',$this->comentario,true);
		$criteria->compare('iduser',$this->iduser);
		$criteria->compare('compartida',$this->compartida,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	    public function beforeSave(){
			if($this->isNewRecord)  {
				$this->iduser=yii::app()->user->id;
			}

			return parent::beforeSave();
		}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Listamateriales the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
