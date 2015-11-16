<?php

/**
 * This is the model class for table "{{coordocs}}".
 *
 * The followings are the available columns in table '{{coordocs}}':
 * @property integer $id
 * @property integer $xgeneral
 * @property integer $ygeneral
 * @property integer $xlogo
 * @property integer $ylogo
 * @property string $codocu
 */
class Coordocs extends ModeloGeneral
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{coordocs}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('xgeneral,nombrereporte, campoestado, ygeneral, xlogo, ylogo,codcen,modelo, codocu', 'required'),
			array('xgeneral, ygeneral, xlogo, ylogo', 'numerical', 'integerOnly'=>true),
			array('codocu', 'length', 'max'=>3),
			array('id, xgeneral,campoestado,estilo,tienelogo,sociedad,tienepie,registrosporpagina,campofiltro,x_grilla,y_grilla, ygeneral,esdetalle,tamanopapel,nombrereporte,detalle, xlogo, ylogo,codcen,modelo, codocu', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, xgeneral, ygeneral, xlogo, ylogo, codocu', 'safe', 'on'=>'search'),
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
			'hijos' => array(self::HAS_MANY, 'Coordreporte', 'hidreporte', 'order'=>'esdetalle ASC'),
			'documento' => array(self::BELONGS_TO, 'Documentos', 'codocu'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'xgeneral' => 'Xgeneral',
			'ygeneral' => 'Ygeneral',
			'xlogo' => 'Xlogo',
			'ylogo' => 'Ylogo',
			'codocu' => 'Codocu',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('xgeneral',$this->xgeneral);
		$criteria->compare('nombrereporte',$this->nombrereporte,true);

		$criteria->compare('ygeneral',$this->ygeneral);
		$criteria->compare('xlogo',$this->xlogo);
		$criteria->compare('ylogo',$this->ylogo);
		//$criteria->addCondition("codocu='".$docu."'");

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Coordocs the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
