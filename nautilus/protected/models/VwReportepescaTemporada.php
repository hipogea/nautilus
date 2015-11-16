<?php

/**
 * This is the model class for table "vw_reportepesca_temporada".
 *
 * The followings are the available columns in table 'vw_reportepesca_temporada':
 * @property integer $idespecie
 * @property integer $idtemporada
 * @property string $sdeclarada
 * @property string $sdescargada
 * @property string $sd2
 * @property string $sct
 * @property string $sfd
 * @property string $nomespecie
 * @property string $bodega
 * @property double $eficienciabodega
 * @property string $horas
 * @property double $d2porhora
 * @property double $horasta
 */
class VwReportepescaTemporada extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwReportepescaTemporada the static model class
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
		return 'vw_reportepesca_temporada';
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
			array('eficienciabodega, d2porhora, horasta', 'numerical'),
			array('sct', 'length', 'max'=>10),
			array('nomespecie', 'length', 'max'=>50),
			array('sdeclarada, sdescargada, sd2, sfd, bodega, horas', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idespecie, idtemporada, sdeclarada, sdescargada, sd2, sct, sfd, nomespecie, bodega, eficienciabodega, horas, d2porhora, horasta', 'safe', 'on'=>'search'),
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
			'idespecie' => 'Idespecie',
			'idtemporada' => 'Idtemporada',
			'sdeclarada' => 'Declarada (tn)',
			'sdescargada' => 'Descargada (tn)',
			'sd2' => 'Combustible (Gl)',
			'sct' => 'Consumo de combustible por tonelada (GL/Tn)',
			'sfd' => 'Factor de descarga (%)',
			'nomespecie' => 'Especie',
			'bodega' => 'Bodega utilizada (TN) ',
			'eficienciabodega' => 'Eficiencia de  bodega utilizada (%) ',
			//'horas' => 'Horas trabajadas totales',
			'd2porhora' => 'Promedio de consumo de petroleo (Gl/h) ',
			'horasta' => 'Horas trabajadas totales',
			'destemporada'=>'Temporada',
			'Inicio' => 'Fecha de inicio',
			'termino'=>'Fecha de termino aproximada',
			'cumplimiento'=>'Avance de captura o Cumplimiento (%)',
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
		$criteria->compare('idespecie',$this->idespecie);
		$criteria->compare('idtemporada',$this->idtemporada);
		$criteria->compare('sdeclarada',$this->sdeclarada,true);
		$criteria->compare('sdescargada',$this->sdescargada,true);
		$criteria->compare('sd2',$this->sd2,true);
		$criteria->compare('sct',$this->sct,true);
		$criteria->compare('sfd',$this->sfd,true);
		$criteria->compare('nomespecie',$this->nomespecie,true);
		$criteria->compare('bodega',$this->bodega,true);
		$criteria->compare('eficienciabodega',$this->eficienciabodega);
		$criteria->compare('horas',$this->horas,true);
		$criteria->compare('d2porhora',$this->d2porhora);
		$criteria->compare('horasta',$this->horasta);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function search_por_temporada($idtemporada)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('idespecie',$this->idespecie);
		$criteria->compare('idtemporada',$this->idtemporada);
		$criteria->compare('sdeclarada',$this->sdeclarada,true);
		$criteria->compare('sdescargada',$this->sdescargada,true);
		$criteria->compare('sd2',$this->sd2,true);
		$criteria->compare('sct',$this->sct,true);
		$criteria->compare('sfd',$this->sfd,true);
		$criteria->compare('nomespecie',$this->nomespecie,true);
		$criteria->compare('bodega',$this->bodega,true);
		$criteria->compare('eficienciabodega',$this->eficienciabodega);
		$criteria->compare('horas',$this->horas,true);
		$criteria->compare('d2porhora',$this->d2porhora);
		$criteria->compare('horasta',$this->horasta);
         $criteria->addCondition("idtemporada = ".$idtemporada."");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function search_por_temporada_anchoveta($idtemporada)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('idespecie',$this->idespecie);
		$criteria->compare('idtemporada',$this->idtemporada);
		$criteria->compare('sdeclarada',$this->sdeclarada,true);
		$criteria->compare('sdescargada',$this->sdescargada,true);
		$criteria->compare('sd2',$this->sd2,true);
		$criteria->compare('sct',$this->sct,true);
		$criteria->compare('sfd',$this->sfd,true);
		$criteria->compare('nomespecie',$this->nomespecie,true);
		$criteria->compare('bodega',$this->bodega,true);
		$criteria->compare('eficienciabodega',$this->eficienciabodega);
		$criteria->compare('horas',$this->horas,true);
		$criteria->compare('d2porhora',$this->d2porhora);
		$criteria->compare('horasta',$this->horasta);
         $criteria->addCondition("idtemporada = ".$idtemporada."");
		  $criteria->addCondition("idespecie = 1");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function search_por_temporada_jurel($idtemporada)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('idespecie',$this->idespecie);
		$criteria->compare('idtemporada',$this->idtemporada);
		$criteria->compare('sdeclarada',$this->sdeclarada,true);
		$criteria->compare('sdescargada',$this->sdescargada,true);
		$criteria->compare('sd2',$this->sd2,true);
		$criteria->compare('sct',$this->sct,true);
		$criteria->compare('sfd',$this->sfd,true);
		$criteria->compare('nomespecie',$this->nomespecie,true);
		$criteria->compare('bodega',$this->bodega,true);
		$criteria->compare('eficienciabodega',$this->eficienciabodega);
		$criteria->compare('horas',$this->horas,true);
		$criteria->compare('d2porhora',$this->d2porhora);
		$criteria->compare('horasta',$this->horasta);
         $criteria->addCondition("idtemporada = ".$idtemporada."");
		  $criteria->addCondition("idespecie = 2");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
}