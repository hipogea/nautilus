<?php

/**
 * This is the model class for table "vw_rppesca_anchoveta".
 *
 * The followings are the available columns in table 'vw_rppesca_anchoveta':
 * @property string $fecha
 * @property integer $idespecie
 * @property integer $idtemporada
 * @property string $sdeclarada
 * @property string $sdescargada
 * @property string $sd2
 * @property string $sct
 * @property string $sfd
 * @property string $nomespecie
 * @property string $bodega
 * @property string $eficienciabodega
 * @property string $horas
 * @property string $d2porhora
 * @property string $horasta
 */
class VwRppescaAnchoveta extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwRppescaAnchoveta the static model class
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
		return 'vw_rppesca_anchoveta';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idespecie, idtemporada', 'numerical', 'integerOnly'=>true),
			array('nomespecie', 'length', 'max'=>50),
			array('fecha, sdeclarada, sdescargada, sd2, sct, sfd, bodega, eficienciabodega, horas, d