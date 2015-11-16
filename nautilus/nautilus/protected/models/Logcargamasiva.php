<?php

/**
 * This is the model class for table "logcargamasiva".
 *
 * The followings are the available columns in table 'logcargamasiva':
 * @property integer $id
 * @property integer $numerolinea
 * @property integer $hidcarga
 * @property string $campo
 * @property string $mensaje
 * @property string $level
 * @property string $fecha
 * @property integer $iduser
 */
class Logcargamasiva extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{logcargamasiva}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('numerolinea, hidcarga, iduser', 'numerical', 'integerOnly'=>true),
			array('campo', 'length', 'max'=>60),
			array('level', 'length', 'max'=>1),
			array('mensaje, fecha', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, numerolinea, hidcarga, campo, mensaje, level, fecha, iduser', 'safe', 'on'=>'search'),
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
			'numerolinea' => 'Numerolinea',
			'hidcarga' => 'Hidcarga',
			'campo' => 'Campo',
			'mensaje' => 'Mensaje',
			'level' => 'Level',
			'fecha' => 'Fecha',
			'iduser' => 'Iduser',
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
		$criteria->compare('numerolinea',$this->numerolinea);
		$criteria->compare('hidcarga',$this->hidcarga);
		$criteria->compare('campo',$this->campo,true);
		$criteria->compare('mensaje',$this->mensaje,true);
		$criteria->compare('level',$this->level,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('iduser',$this->iduser);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	
	
	public function search_carga($idcarga)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('numerolinea',$this->numerolinea);
		$criteria->compare('hidcarga',$this->hidcarga);
		$criteria->compare('campo',$this->campo,true);
		$criteria->compare('mensaje',$this->mensaje,true);
		$criteria->compare('level',$this->level,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('iduser',$this->iduser);
		$criteria->addcondition('hidcarga='.$idcarga);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>400000),
			
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Logcargamasiva the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
