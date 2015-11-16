<?php

/**
 * This is the model class for table "vw_parte_pesca".
 *
 * The followings are the available columns in table 'vw_parte_pesca':
 * @property string $codcentro
 * @property integer $id
 * @property integer $semana
 * @property string $codep
 * @property string $fecha
 * @property string $evento
 * @property string $fechazarpe
 * @property integer $r4
 * @property integer $r5
 * @property integer $r6
 * @property integer $r7
 * @property integer $r8
 * @property integer $r9
 * @property integer $r10
 * @property integer $r11
 * @property integer $d2
 * @property integer $declarada
 * @property double $descargada
 * @property string $zonapesca
 * @property string $latitud
 * @property string $meridiano
 * @property string $zona
 * @property integer $capbodega
 * @property string $nomep
 * @property string $nomespecie
 * @property string $motivozarpe
 * @property string $plantazarpe_desplanta
 * @property string $plantadestino_desplanta
 * @property string $consumoportonelada
 * @property string $factordescarga
 * @property double $horas
 * @property string $consumoporhora
 */
class VwPartePesca extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwPartePesca the static model class
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
		return 'vw_parte_pesca';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, semana, r4, r5, r6, r7, r8, r9, r10, r11, d2, declarada, capbodega', 'numerical', 'integerOnly'=>true),
			array('descargada, horas', 'numerical'),
			array('codcentro', 'length', 'max'=>4),
			array('codep', 'length', 'max'=>3),
			array('evento, zona', 'length', 'max'=>1),
			array('zonapesca, nomep, plantazarpe_desplanta, plantadestino_desplanta', 'length', 'max'=>25),
			array('latitud, meridiano', 'length', 'max'=>6),
			array('nomespecie', 'length', 'max'=>50),
			array('motivozarpe', 'length', 'max'=>40),
			array('fecha, fechazarpe, consumoportonelada, factordescarga, consumoporhora', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codcentro, id,idtemporada, semana, codep, fecha, evento, fechazarpe, r4, r5, r6, r7, r8, r9, r10, r11, d2, declarada, descargada, zonapesca, latitud, meridiano, zona, capbodega, nomep, nomespecie, motivozarpe, plantazarpe_desplanta, plantadestino_desplanta, consumoportonelada, factordescarga, horas, consumoporhora', 'safe', 'on'=>'search'),
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
			'codcentro' => 'Codcentro',
			'id' => 'ID',
			'semana' => 'Semana',
			'codep' => 'Codep',
			'fecha' => 'Fecha',
			'evento' => 'Evento',
			'fechazarpe' => 'Fechazarpe',
			'r4' => 'R4',
			'r5' => 'R5',
			'r6' => 'R6',
			'r7' => 'R7',
			'r8' => 'R8',
			'r9' => 'R9',
			'r10' => 'R10',
			'r11' => 'R11',
			'd2' => 'D2',
			'declarada' => 'Declarada',
			'descargada' => 'Descargada',
			'zonapesca' => 'Zonapesca',
			'latitud' => 'Latitud',
			'meridiano' => 'Meridiano',
			'zona' => 'Zona',
			'capbodega' => 'Capbodega',
			'nomep' => 'Nomep',
			'nomespecie' => 'Nomespecie',
			'motivozarpe' => 'Motivozarpe',
			'plantazarpe_desplanta' => 'Plantazarpe Desplanta',
			'plantadestino_desplanta' => 'Plantadestino Desplanta',
			'consumoportonelada' => 'Consumoportonelada',
			'factordescarga' => 'Factordescarga',
			'horas' => 'Horas',
			'consumoporhora' => 'Consumoporhora',
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

		$criteria->compare('codcentro',$this->codcentro,true);
		$criteria->compare('id',$this->id);
		$criteria->compare('semana',$this->semana);
		$criteria->compare('codep',$this->codep,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('evento',$this->evento,true);
		$criteria->compare('fechazarpe',$this->fechazarpe,true);
		$criteria->compare('r4',$this->r4);
		$criteria->compare('r5',$this->r5);
		$criteria->compare('r6',$this->r6);
		$criteria->compare('r7',$this->r7);
		$criteria->compare('r8',$this->r8);
		$criteria->compare('r9',$this->r9);
		$criteria->compare('r10',$this->r10);
		$criteria->compare('r11',$this->r11);
		$criteria->compare('d2',$this->d2);
		$criteria->compare('declarada',$this->declarada);
		$criteria->compare('descargada',$this->descargada);
		$criteria->compare('zonapesca',$this->zonapesca,true);
		$criteria->compare('latitud',$this->latitud,true);
		$criteria->compare('meridiano',$this->meridiano,true);
		$criteria->compare('zona',$this->zona,true);
		$criteria->compare('capbodega',$this->capbodega);
		$criteria->compare('nomep',$this->nomep,true);
		$criteria->compare('nomespecie',$this->nomespecie,true);
		$criteria->compare('motivozarpe',$this->motivozarpe,true);
		$criteria->compare('plantazarpe_desplanta',$this->plantazarpe_desplanta,true);
		$criteria->compare('plantadestino_desplanta',$this->plantadestino_desplanta,true);
		$criteria->compare('consumoportonelada',$this->consumoportonelada,true);
		$criteria->compare('factordescarga',$this->factordescarga,true);
		$criteria->compare('horas',$this->horas);
		$criteria->compare('consumoporhora',$this->consumoporhora,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function search_dia($fechita)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('codcentro',$this->codcentro,true);
		$criteria->compare('id',$this->id);
		$criteria->compare('semana',$this->semana);
		$criteria->compare('codep',$this->codep,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('evento',$this->evento,true);
		$criteria->compare('fechazarpe',$this->fechazarpe,true);
		$criteria->compare('r4',$this->r4);
		$criteria->compare('r5',$this->r5);
		$criteria->compare('r6',$this->r6);
		$criteria->compare('r7',$this->r7);
		$criteria->compare('r8',$this->r8);
		$criteria->compare('r9',$this->r9);
		$criteria->compare('r10',$this->r10);
		$criteria->compare('r11',$this->r11);
		$criteria->compare('d2',$this->d2);
		$criteria->compare('declarada',$this->declarada);
		$criteria->compare('descargada',$this->descargada);
		$criteria->compare('zonapesca',$this->zonapesca,true);
		$criteria->compare('latitud',$this->latitud,true);
		$criteria->compare('meridiano',$this->meridiano,true);
		$criteria->compare('zona',$this->zona,true);
		$criteria->compare('capbodega',$this->capbodega);
		$criteria->compare('nomep',$this->nomep,true);
		$criteria->compare('nomespecie',$this->nomespecie,true);
		$criteria->compare('motivozarpe',$this->motivozarpe,true);
		$criteria->compare('plantazarpe_desplanta',$this->plantazarpe_desplanta,true);
		$criteria->compare('plantadestino_desplanta',$this->plantadestino_desplanta,true);
		$criteria->compare('consumoportonelada',$this->consumoportonelada,true);
		$criteria->compare('factordescarga',$this->factordescarga,true);
		$criteria->compare('horas',$this->horas);
		$criteria->compare('consumoporhora',$this->consumoporhora,true);
		$criteria->addCondition("fecha ='".$fechita."'");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
										'pageSize' => 40,
												),
		));
		
	}
}