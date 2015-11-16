<?php

/**
 * This is the model class for table "vw_rppesca_jurel".
 *
 * The followings are the available columns in table 'vw_rppesca_jurel':
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
class VwRppescaJurel extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwRppescaJurel the static model class
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
		return 'vw_rppesca_jurel';
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
			array('fecha, sdeclarada, sdescargada, sd2, sct, sfd, bodega, eficienciabodega, horas, d2porhora, horasta', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('fecha, idespecie, idtemporada, sdeclarada, sdescargada, sd2, sct, sfd, nomespecie, bodega, eficienciabodega, horas, d2porhora, horasta', 'safe', 'on'=>'search'),
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
			'fecha' => 'Fecha',
			'idespecie' => 'Idespecie',
			'idtemporada' => 'Idtemporada',
			'sdeclarada' => 'Sdeclarada',
			'sdescargada' => 'Sdescargada',
			'sd2' => 'Sd2',
			'sct' => 'Sct',
			'sfd' => 'Sfd',
			'nomespecie' => 'Nomespecie',
			'bodega' => 'Bodega',
			'eficienciabodega' => 'Eficienciabodega',
			'horas' => 'Horas',
			'd2porhora' => 'D2porhora',
			'horasta' => 'Horasta',
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

		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('idespecie',$this->idespecie);
		$criteria->compare('idtemporada',$this->idtemporada);
		$criteria->compare('sdeclarada',$this->sdeclarada,true);
		$criteria->compare('sdescargada',$this->sdescargada,true);
		$criteria->compare('sd2',$this->sd2,true);
		$criteria->compare('sct',$this->sct,true);
		$criteria->compare('sfd',$this->sfd,true);
		$criteria->compare('nomespecie',$this->nomespecie,true);
		$criteria->compare('bodega',$this->bodega,true);
		$criteria->compare('eficienciabodega',$this->eficienciabodega,true);
		$criteria->compare('horas',$this->horas,true);
		$criteria->compare('d2porhora',$this->d2porhora,true);
		$criteria->compare('horasta',$this->horasta,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function search_por_dia($fecha)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('idespecie',$this->idespecie);
		$criteria->compare('idtemporada',$this->idtemporada);
		$criteria->compare('sdeclarada',$this->sdeclarada,true);
		$criteria->compare('sdescargada',$this->sdescargada,true);
		$criteria->compare('sd2',$this->sd2,true);
		$criteria->compare('sct',$this->sct,true);
		$criteria->compare('sfd',$this->sfd,true);
		$criteria->addCondition("fecha= '".$fecha."'");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function search_por_temporada($idtemporada)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('idespecie',$this->idespecie);
		$criteria->compare('idtemporada',$this->idtemporada);
		$criteria->compare('sdeclarada',$this->sdeclarada,true);
		$criteria->compare('sdescargada',$this->sdescargada,true);
		$criteria->compare('sd2',$this->sd2,true);
		$criteria->compare('sct',$this->sct,true);
		$criteria->compare('sfd',$this->sfd,true);
		$criteria->addCondition("idtemporada= ".$idtemporada);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	
}