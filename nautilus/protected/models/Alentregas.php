<?php

/**
 * This is the model class for table "alentregas".
 *
 * The followings are the available columns in table 'alentregas':
 * @property integer $id
 * @property string $iddetcompra
 * @property double $cant
 * @property string $fecha
 * @property string $idkardex
 * @property string $usuario
 */
class Alentregas extends CActiveRecord
{

	const ESTADO_CREADO='10';
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->params['prefijo'].'alentregas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cant', 'numerical'),
			array('usuario', 'length', 'max'=>30),
			array('iddetcompra, fecha, idkardex', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, iddetcompra, cant, fecha, idkardex, usuario', 'safe', 'on'=>'search'),
		);
	}
public $sumatoria;
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(

				'alentregas_docompra' => array(self::BELONGS_TO, 'Docompra', 'iddetcompra','with'=>'docompra_ocompra'),
				'alentregas_alkardex'=>array(self::BELONGS_TO, 'Alkardex', 'idkardex'),
			'facturas'=>array(self::HAS_MANY, 'Detingfactura', 'hidalentrega'),


		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'iddetcompra' => 'Iddetcompra',
			'cant' => 'Cant',
			'fecha' => 'Fecha',
			'idkardex' => 'Idkardex',
			'usuario' => 'Usuario',
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
		$criteria->compare('iddetcompra',$this->iddetcompra,true);
		$criteria->compare('cant',$this->cant);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('idkardex',$this->idkardex,true);
		$criteria->compare('usuario',$this->usuario,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function search_ide($id)
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('iddetcompra',$this->iddetcompra,true);
        $criteria->compare('cant',$this->cant);
        $criteria->compare('fecha',$this->fecha,true);
        $criteria->compare('idkardex',$this->idkardex,true);
        $criteria->compare('usuario',$this->usuario,true);
        $criteria->addcondition("iddetcompra=".$id."");
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}