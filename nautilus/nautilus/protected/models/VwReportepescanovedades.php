<?php

/**
 * This is the model class for table "vw_reportepescanovedades".
 *
 * The followings are the available columns in table 'vw_reportepescanovedades':
 * @property integer $idnovedad
 * @property string $criticidad
 * @property string $lugar
 * @property string $latitud
 * @property string $hora
 * @property string $descri
 * @property string $descridetalle
 * @property string $idpartepesca
 * @property integer $id
 * @property string $codep
 * @property string $fecha
 * @property string $nomep
 */
class VwReportepescanovedades extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwReportepescanovedades the static model class
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
		return 'vw_reportepescanovedades';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idnovedad, id', 'numerical', 'integerOnly'=>true),
			array('criticidad', 'length', 'max'=>1),
			array('lugar, descri', 'length', 'max'=>30),
			array('latitud', 'length', 'max'=>6),
			array('codep', 'length', 'max'=>3),
			array('nomep', 'length', 'max'=>25),
			array('hora, descridetalle, idpartepesca, fecha', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idnovedad, criticidad, lugar, latitud, hora, descri, descridetalle, idpartepesca, id, codep, fecha, nomep', 'safe', 'on'=>'search'),
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
			'idnovedad' => 'Idnovedad',
			'criticidad' => 'Criticidad',
			'lugar' => 'Lugar',
			'latitud' => 'Latitud',
			'hora' => 'Hora',
			'descri' => 'Descripcion',
			'descridetalle' => 'Descripcion_larga_de_la_novedad',
			'idpartepesca' => 'Idpartepesca',
			'id' => 'ID',
			'codep' => 'Codep',
			'fecha' => 'Fecha',
			'nomep' => 'Embarcacion',
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

		$criteria->compare('idnovedad',$this->idnovedad);
		$criteria->compare('criticidad',$this->criticidad,true);
		$criteria->compare('lugar',$this->lugar,true);
		$criteria->compare('latitud',$this->latitud,true);
		$criteria->compare('hora',$this->hora,true);
		$criteria->compare('descri',$this->descri,true);
		$criteria->compare('descridetalle',$this->descridetalle,true);
		$criteria->compare('idpartepesca',$this->idpartepesca,true);
		$criteria->compare('id',$this->id);
		$criteria->compare('codep',$this->codep,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('nomep',$this->nomep,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			
		));
	}
	
	
	public function search_fecha($fechita)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('idnovedad',$this->idnovedad);
		$criteria->compare('criticidad',$this->criticidad,true);
		$criteria->compare('lugar',$this->lugar,true);
		$criteria->compare('latitud',$this->latitud,true);
		$criteria->compare('hora',$this->hora,true);
		$criteria->compare('descri',$this->descri,true);
		$criteria->compare('descridetalle',$this->descridetalle,true);
		$criteria->compare('idpartepesca',$this->idpartepesca,true);
		$criteria->compare('id',$this->id);
		$criteria->compare('codep',$this->codep,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('nomep',$this->nomep,true);
		$criteria->addCondition("fecha ='".$fechita."'");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
										'pageSize' => 15,
												),
		));
	}
	
	
	
	
	
	
	
}