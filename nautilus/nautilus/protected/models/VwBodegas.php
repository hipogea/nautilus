<?php

/**
 * This is the model class for table "vw_bodegas".
 *
 * The followings are the available columns in table 'vw_bodegas':
 * @property string $codep
 * @property string $nomep
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
 * @property string $destemporada
 * @property string $inicio
 * @property string $termino
 * @property integer $cuota_anchoveta
 * @property integer $cuota_global_anchoveta
 * @property string $cumplimiento
 */
class VwBodegas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwBodegas the static model class
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
		return 'vw_bodegas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idespecie, idtemporada, cuota_anchoveta, cuota_global_anchoveta', 'numerical', 'integerOnly'=>true),
			array('codep', 'length', 'max'=>3),
			array('nomep', 'length', 'max'=>25),
			array('nomespecie', 'length', 'max'=>50),
			array('destemporada', 'length', 'max'=>60),
			array('sdeclarada, sdescargada, sd2, sct, sfd, bodega, eficienciabodega,  inicio, termino, cumplimiento', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codep, nomep, idespecie, idtemporada, sdeclarada, sdescargada,eficienciabodega, horas, destemporada, inicio, termino, cuota_anchoveta, cuota_global_anchoveta, cumplimiento', 'safe', 'on'=>'search'),
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
			'codep' => 'Codep',
			'nomep' => 'Nomep',
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
			'destemporada' => 'Destemporada',
			'inicio' => 'Inicio',
			'termino' => 'Termino',
			'cuota_anchoveta' => 'Cuota Anchoveta',
			'cuota_global_anchoveta' => 'Cuota Global Anchoveta',
			'cumplimiento' => 'Cumplimiento',
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

		$criteria->compare('codep',$this->codep,true);
		$criteria->compare('nomep',$this->nomep,true);
		$criteria->compare('idespecie',$this->idespecie);
		$criteria->compare('idtemporada',$this->idtemporada);
		$criteria->compare('sdeclarada',$this->sdeclarada,true);
		$criteria->compare('sdescargada',$this->sdescargada,true);
	//	$criteria->compare('sd2',$this->sd2,true);
	//	$criteria->compare('sct',$this->sct,true);
		$criteria->compare('sfd',$this->sfd,true);
		$criteria->compare('nomespecie',$this->nomespecie,true);
		$criteria->compare('bodega',$this->bodega,true);
		$criteria->compare('eficienciabodega',$this->eficienciabodega,true);
	//	$criteria->compare('horas',$this->horas,true);
	//	$criteria->compare('d2porhora',$this->d2porhora,true);
	//	$criteria->compare('horasta',$this->horasta,true);
		$criteria->compare('destemporada',$this->destemporada,true);
		$criteria->compare('inicio',$this->inicio,true);
		$criteria->compare('termino',$this->termino,true);
		$criteria->compare('cuota_anchoveta',$this->cuota_anchoveta);
		$criteria->compare('cuota_global_anchoveta',$this->cuota_global_anchoveta);
		$criteria->compare('cumplimiento',$this->cumplimiento,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	
	public function search_temporada($idtemporada)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('eficienciabodega',$this->eficienciabodega,true);
		$criteria->compare('codep',$this->codep,true);
		$criteria->compare('nomep',$this->nomep,true);
		$criteria->compare('idespecie',$this->idespecie);
		$criteria->compare('idtemporada',$this->idtemporada);
		$criteria->compare('sdeclarada',$this->sdeclarada,true);
		$criteria->compare('sdescargada',$this->sdescargada,true);
		//$criteria->compare('sd2',$this->sd2,true);
	//	$criteria->compare('sct',$this->sct,true);
		$criteria->compare('sfd',$this->sfd,true);
		$criteria->compare('nomespecie',$this->nomespecie,true);
		$criteria->compare('bodega',$this->bodega,true);
		
		//$criteria->compare('horas',$this->horas,true);
		//$criteria->compare('d2porhora',$this->d2porhora,true);
		//$criteria->compare('horasta',$this->horasta,true);
		$criteria->compare('destemporada',$this->destemporada,true);
		$criteria->compare('inicio',$this->inicio,true);
		$criteria->compare('termino',$this->termino,true);
		$criteria->compare('cuota_anchoveta',$this->cuota_anchoveta);
		$criteria->compare('cuota_global_anchoveta',$this->cuota_global_anchoveta);
		$criteria->compare('cumplimiento',$this->cumplimiento,true);
			 $criteria->addCondition("idtemporada = ".$idtemporada."");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,'pagination' => array(
                'pageSize' => 30,
            ),
		));
	}
	
	
	public function search_temporada_anchoveta($idtemporada)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('eficienciabodega',$this->eficienciabodega,true);
		$criteria->compare('codep',$this->codep,true);
		$criteria->compare('nomep',$this->nomep,true);
		$criteria->compare('idespecie',$this->idespecie);
		$criteria->compare('idtemporada',$this->idtemporada);
		$criteria->compare('sdeclarada',$this->sdeclarada,true);
		$criteria->compare('sdescargada',$this->sdescargada,true);
		//$criteria->compare('sd2',$this->sd2,true);
	//	$criteria->compare('sct',$this->sct,true);
		$criteria->compare('sfd',$this->sfd,true);
		$criteria->compare('nomespecie',$this->nomespecie,true);
		$criteria->compare('bodega',$this->bodega,true);
		$criteria->compare('eficienciabodega',$this->eficienciabodega,true);
		//$criteria->compare('horas',$this->horas,true);
		//$criteria->compare('d2porhora',$this->d2porhora,true);
		//$criteria->compare('horasta',$this->horasta,true);
		$criteria->compare('destemporada',$this->destemporada,true);
		$criteria->compare('inicio',$this->inicio,true);
		$criteria->compare('termino',$this->termino,true);
		$criteria->compare('cuota_anchoveta',$this->cuota_anchoveta);
		$criteria->compare('cuota_global_anchoveta',$this->cuota_global_anchoveta);
		$criteria->compare('cumplimiento',$this->cumplimiento,true);
			 $criteria->addCondition("idtemporada = ".$idtemporada."");
			 $criteria->addCondition("idespecie = 1");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,'pagination' => array(
                'pageSize' => 30,
            ),
		));
	}
	
	public function search_temporada_jurel($idtemporada)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('codep',$this->codep,true);
		$criteria->compare('nomep',$this->nomep,true);
		$criteria->compare('idespecie',$this->idespecie);
		$criteria->compare('idtemporada',$this->idtemporada);
		$criteria->compare('sdeclarada',$this->sdeclarada,true);
		$criteria->compare('sdescargada',$this->sdescargada,true);
		//$criteria->compare('sd2',$this->sd2,true);
	//	$criteria->compare('sct',$this->sct,true);
		$criteria->compare('sfd',$this->sfd,true);
		$criteria->compare('nomespecie',$this->nomespecie,true);
		$criteria->compare('bodega',$this->bodega,true);
		$criteria->compare('eficienciabodega',$this->eficienciabodega,true);
		//$criteria->compare('horas',$this->horas,true);
		//$criteria->compare('d2porhora',$this->d2porhora,true);
		//$criteria->compare('horasta',$this->horasta,true);
		$criteria->compare('destemporada',$this->destemporada,true);
		$criteria->compare('inicio',$this->inicio,true);
		$criteria->compare('termino',$this->termino,true);
		$criteria->compare('cuota_anchoveta',$this->cuota_anchoveta);
		$criteria->compare('cuota_global_anchoveta',$this->cuota_global_anchoveta);
		$criteria->compare('cumplimiento',$this->cumplimiento,true);
			 $criteria->addCondition("idtemporada = ".$idtemporada."");
			 $criteria->addCondition("idespecie = 2");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,'pagination' => array(
                'pageSize' => 30,
            ),
		));
	}
	
	
	
	
	public function search_por_fecha($fecha1,$fecha2)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('codep',$this->codep,true);
		$criteria->compare('nomep',$this->nomep,true);
		$criteria->compare('idespecie',$this->idespecie);
		$criteria->compare('idtemporada',$this->idtemporada);
		$criteria->compare('sdeclarada',$this->sdeclarada,true);
		$criteria->compare('sdescargada',$this->sdescargada,true);
		//$criteria->compare('sd2',$this->sd2,true);
	//	$criteria->compare('sct',$this->sct,true);
		$criteria->compare('sfd',$this->sfd,true);
		$criteria->compare('nomespecie',$this->nomespecie,true);
		$criteria->compare('bodega',$this->bodega,true);
		$criteria->compare('eficienciabodega',$this->eficienciabodega,true);
		//$criteria->compare('horas',$this->horas,true);
		//$criteria->compare('d2porhora',$this->d2porhora,true);
		//$criteria->compare('horasta',$this->horasta,true);
		$criteria->compare('destemporada',$this->destemporada,true);
		$criteria->compare('inicio',$this->inicio,true);
		$criteria->compare('termino',$this->termino,true);
		$criteria->compare('cuota_anchoveta',$this->cuota_anchoveta);
		$criteria->compare('cuota_global_anchoveta',$this->cuota_global_anchoveta);
		$criteria->compare('cumplimiento',$this->cumplimiento,true);
			 $criteria->addCondition("idtemporada = ".$idtemporada."");
			 $criteria->addCondition("idespecie = 2");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,'pagination' => array(
                'pageSize' => 30,
            ),
		));
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}