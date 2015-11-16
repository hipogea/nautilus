<?php

/**
 * This is the model class for table "{{montoinventario}}".
 *
 * The followings are the available columns in table '{{montoinventario}}':
 * @property integer $id
 * @property string $dia
 * @property string $mes
 * @property string $anno
 * @property integer $iduser
 * @property string $montolibre
 * @property string $montoreserva
 * @property string $montotran
 * @property string $montodif
 * @property string $codal
 * @property string $codcen
 * @property string $codgrupo
 * @property integer $numitems
 * @property string $fecha
 */
class Montoinventario extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{montoinventario}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dia, mes, anno, iduser, montolibre, montoreserva, montotran, montodif, codal, codcen,fecha', 'required'),
			array('dia, mes, anno, iduser, montolibre, montoreserva, montotran, montodif, codal,montototal, codcen,fecha', 'safe'),

			array('iduser, numitems', 'numerical', 'integerOnly'=>true),
			array('dia, mes, anno', 'length', 'max'=>2),
			array('montolibre, montoreserva, montotran, montodif', 'length', 'max'=>15),
			array('codal', 'length', 'max'=>3),
			array('codcen, codgrupo', 'length', 'max'=>4),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, dia, mes, anno, iduser, montolibre, montoreserva, montotran, montodif, codal, codcen, codgrupo, numitems, fecha', 'safe', 'on'=>'search'),
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
			'dia' => 'Dia',
			'mes' => 'Mes',
			'anno' => 'Anno',
			'iduser' => 'Iduser',
			'montolibre' => 'Montolibre',
			'montoreserva' => 'Montoreserva',
			'montotran' => 'Montotran',
			'montodif' => 'Montodif',
			'codal' => 'Codal',
			'codcen' => 'Codcen',
			'codgrupo' => 'Codgrupo',
			'numitems' => 'Numitems',
			'fecha' => 'Fecha',
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
		$criteria->compare('dia',$this->dia,true);
		$criteria->compare('mes',$this->mes,true);
		$criteria->compare('anno',$this->anno,true);
		$criteria->compare('iduser',$this->iduser);
		$criteria->compare('montolibre',$this->montolibre,true);
		$criteria->compare('montoreserva',$this->montoreserva,true);
		$criteria->compare('montotran',$this->montotran,true);
		$criteria->compare('montodif',$this->montodif,true);
		$criteria->compare('codal',$this->codal,true);
		$criteria->compare('codcen',$this->codcen,true);
		$criteria->compare('codgrupo',$this->codgrupo,true);
		$criteria->compare('numitems',$this->numitems);
		$criteria->compare('fecha',$this->fecha,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Montoinventario the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
