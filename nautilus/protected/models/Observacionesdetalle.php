<?php

/**
 * This is the model class for table "observacionesdetalle".
 *
 * The followings are the available columns in table 'observacionesdetalle':
 * @property string $hidobservaciones
 * @property string $comentario
 * @property string $usuario
 * @property string $fecha
 * @property integer $id
 *
 * The followings are the available model relations:
 * @property Observaciones $hidobservaciones0
 */
class Observacionesdetalle extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Observacionesdetalle the static model class
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
		return '{{observacionesdetalle}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usuario', 'length', 'max'=>35),
			array('hidobservaciones, comentario, fecha', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('hidobservaciones, comentario, usuario, fecha, id', 'safe', 'on'=>'search'),
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
			'hidobservaciones0' => array(self::BELONGS_TO, 'Observaciones', 'hidobservaciones'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'hidobservaciones' => 'Hidobservaciones',
			'comentario' => 'Comentario',
			'usuario' => 'Usuario',
			'fecha' => 'Fecha',
			'id' => 'ID',
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

		$criteria->compare('hidobservaciones',$this->hidobservaciones,true);
		$criteria->compare('comentario',$this->comentario,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('id',$this->id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}