<?php

/**
 * This is the model class for table "{{solcotizacion}}".
 *
 * The followings are the available columns in table '{{solcotizacion}}':
 * @property string $id
 * @property string $hidesolpe
 * @property string $codpro
 * @property integer $preciounit
 * @property integer $dispo
 * @property integer $iduser
 * @property string $fechacrea
 * @property string $codmon
 * @property string $um
 * @property string $comentario
 * @property string $frespuesta
 *
 * The followings are the available model relations:
 * @property Clipro $codpro0
 * @property Desolpe1 $hidesolpe0
 * @property Ums $um0
 */
class Solcotizacion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{solcotizacion}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hidesolpe, codpro, preciounit, dispo, iduser, fechacrea, codmon, um, comentario, frespuesta', 'required'),
			array('preciounit, dispo, iduser', 'numerical', 'integerOnly'=>true),
			array('hidesolpe', 'length', 'max'=>20),
			array('codpro', 'length', 'max'=>8),
			array('codmon, um', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, hidesolpe, codpro, preciounit, dispo, iduser, fechacrea, codmon, um, comentario, frespuesta', 'safe', 'on'=>'search'),
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
			'clipro' => array(self::BELONGS_TO, 'Clipro', 'codpro'),
			'desolpe' => array(self::BELONGS_TO, 'Desolpe', 'hidesolpe'),
			'um' => array(self::BELONGS_TO, 'Ums', 'um'),
			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'hidesolpe' => 'Hidesolpe',
			'codpro' => 'Codpro',
			'preciounit' => 'Preciounit',
			'dispo' => 'Dispo',
			'iduser' => 'Iduser',
			'fechacrea' => 'Fechacrea',
			'codmon' => 'Codmon',
			'um' => 'Um',
			'comentario' => 'Comentario',
			'frespuesta' => 'Frespuesta',
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
		$criteria->compare('hidesolpe',$this->hidesolpe,true);
		$criteria->compare('codpro',$this->codpro,true);
		$criteria->compare('preciounit',$this->preciounit);
		$criteria->compare('dispo',$this->dispo);
		$criteria->compare('iduser',$this->iduser);
		$criteria->compare('fechacrea',$this->fechacrea,true);
		$criteria->compare('codmon',$this->codmon,true);
		$criteria->compare('um',$this->um,true);
		$criteria->compare('comentario',$this->comentario,true);
		$criteria->compare('frespuesta',$this->frespuesta,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Solcotizacion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
