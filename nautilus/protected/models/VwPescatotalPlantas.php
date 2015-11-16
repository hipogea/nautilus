<?php

/**
 * This is the model class for table "vw_pescatotalplantas".
 *
 * The followings are the available columns in table 'vw_pescatotalplantas':
 * @property string $pescapropia
 * @property string $barcospropios
 * @property string $fecha
 * @property string $codplantadestino
 * @property string $desplanta
 * @property string $promediopropia
 * @property string $codplanta
 * @property integer $pesca
 * @property integer $numeroep
 * @property string $pescatotal
 * @property string $barcostotales
 * @property integer $capacidad
 * @property string $falta
 * @property string $saturacion
 */
class VwPescatotalPlantas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwPescatotalPlantas the static model class
	 */
	 public $imagenp ;
	 PUBLIC $imagesepara1;
	 PUBLIC $imagesepara2;
	 PUBLIC $imagesepara3;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vw_pescatotalplantas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pesca, numeroep, capacidad', 'numerical', 'integerOnly'=>true),
			array('codplantadestino, codplanta', 'length', 'max'=>2),
			array('desplanta', 'length', 'max'=>25),
			array('pescapropia, barcospropios, fecha, promediopropia, pescatotal, barcostotales, falta, saturacion', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pescapropia, barcospropios, fecha, codplantadestino, desplanta, promediopropia, codplanta, pesca, numeroep, pescatotal, barcostotales, capacidad, falta, saturacion', 'safe', 'on'=>'search'),
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
			'pescapropia' => 'Pesca propia (TN)',
			'barcospropios' => 'Flota Propia',
			'fecha' => 'Fecha',
			'codplantadestino' => 'Codplantadestino',
			'desplanta' => 'Planta',
			'promediopropia' => 'Prom. Propia (TN)',
			'codplanta' => 'Codplanta',
			'pesca' => 'Pesca Terceros (TN)',
			'numeroep' => 'Flota terceros',			
			'barcostotales' => 'Flota total',
			'pescatotal' => 'Pesca Total (TN)',
			'capacidad' => 'Cap. planta',
			'falta' => 'Faltan (TN)',
			'saturacion' => 'Saturacion',
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

		$criteria->compare('pescapropia',$this->pescapropia,true);
		$criteria->compare('barcospropios',$this->barcospropios,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('codplantadestino',$this->codplantadestino,true);
		$criteria->compare('desplanta',$this->desplanta,true);
		$criteria->compare('promediopropia',$this->promediopropia,true);
		$criteria->compare('codplanta',$this->codplanta,true);
		$criteria->compare('pesca',$this->pesca);
		$criteria->compare('numeroep',$this->numeroep);
		$criteria->compare('pescatotal',$this->pescatotal,true);
		$criteria->compare('barcostotales',$this->barcostotales,true);
		$criteria->compare('capacidad',$this->capacidad);
		$criteria->compare('falta',$this->falta,true);
		$criteria->compare('saturacion',$this->saturacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function search_dia($fecha,$idtemporada)
	{
			$criteria=new CDbCriteria;

		$criteria->compare('pescapropia',$this->pescapropia,true);
		$criteria->compare('barcospropios',$this->barcospropios,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('codplantadestino',$this->codplantadestino,true);
		$criteria->compare('desplanta',$this->desplanta,true);
		$criteria->compare('promediopropia',$this->promediopropia,true);
		$criteria->compare('codplanta',$this->codplanta,true);
		$criteria->compare('pesca',$this->pesca);
		$criteria->compare('numeroep',$this->numeroep);
		$criteria->compare('pescatotal',$this->pescatotal,true);
		$criteria->compare('barcostotales',$this->barcostotales,true);
		$criteria->compare('capacidad',$this->capacidad);
		$criteria->compare('falta',$this->falta,true);
		$criteria->compare('saturacion',$this->saturacion,true);
		$criteria->addCondition(" fecha= '".$fecha."'");
		$criteria->addCondition(" idtemporada= ".$idtemporada."");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
										'pageSize' => 40,
												),
		));
	}
	
	
	
}