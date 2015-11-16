<?php
CONST COD_MOVIMIENTO_TRASLADO='77';
/**
 * This is the model class for table "vw_traspasospendientes".
 *
 * The followings are the available columns in table 'vw_traspasospendientes':
 * @property string $numvale
 * @property string $codaldestino
 * @property string $fechacont
 * @property string $codart
 * @property string $descripcion
 * @property string $desum
 * @property double $cantpendiente
 */
class VwTraspasospendientes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vw_traspasospendientes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cantpendiente', 'numerical'),
			array('numvale', 'length', 'max'=>12),
			array('codaldestino', 'length', 'max'=>3),
			array('codart', 'length', 'max'=>10),
			array('descripcion', 'length', 'max'=>60),
			array('desum', 'length', 'max'=>20),
			array('fechacont', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('numvale, codaldestino, fechacont, codart, descripcion, desum, cantpendiente', 'safe', 'on'=>'search'),
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
			'numvale' => 'Numvale',
			'codaldestino' => 'Codaldestino',
			'fechacont' => 'Fechacont',
			'codart' => 'Codart',
			'descripcion' => 'Descripcion',
			'desum' => 'Desum',
			'cantpendiente' => 'Cantpendiente',
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

		$criteria->compare('numvale',$this->numvale,true);
		$criteria->compare('codaldestino',$this->codaldestino,true);
		$criteria->compare('fechacont',$this->fechacont,true);
		$criteria->compare('codart',$this->codart,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('desum',$this->desum,true);
		$criteria->compare('cantpendiente',$this->cantpendiente);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public function search_por_almacen($codal)
	{
		$codal=MiFactoria::cleanInput($codal);
		//
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('numvale',$this->numvale,true);
		$criteria->compare('codaldestino',$this->codaldestino,true);
		$criteria->compare('fechacont',$this->fechacont,true);
		$criteria->compare('codart',$this->codart,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('desum',$this->desum,true);
		$criteria->compare('cantpendiente',$this->cantpendiente);
		$criteria->addcondition("alemi='".$codal."'");
		$criteria->addcondition("codmov='".COD_MOVIMIENTO_TRASLADO."'");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VwTraspasospendientes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
