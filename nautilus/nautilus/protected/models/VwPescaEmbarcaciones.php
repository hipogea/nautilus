<?php

/**
 * This is the model class for table "vw_pesca_embarcaciones".
 *
 * The followings are the available columns in table 'vw_pesca_embarcaciones':
 * @property string $codep
 * @property string $nomep
 * @property integer $idespecie
 * @property integer $idtemporada
 * @property string $sdeclarada
 * @property double $sdescargada
 * @property string $sd2
 * @property string $sct
 * @property string $sfd
 * @property string $nomespecie
 * @property string $bodega
 * @property string $eficienciabodega
 * @property string $horas
 * @property string $d2porhora
 * @property double $horasta
 */
class VwPescaEmbarcaciones extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwPescaEmbarcaciones the static model class
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
		return 'vw_pesca_embarcaciones';
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
			array('sdescargada, horasta', 'numerical'),
			array('codep', 'length', 'max'=>3),
			array('nomep', 'length', 'max'=>25),
			array('nomespecie', 'length', 'max'=>50),
			array('sdeclarada, sd2, sct, sfd, bodega, eficienciabodega, horas, d2porhora', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codep, nomep, idespecie, idtemporada, sdeclarada, sdescargada, sd2, sct, sfd, nomespecie, bodega, eficienciabodega, horas, d2porhora, horasta', 'safe', 'on'=>'search'),
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
			'nomep' => 'Embarcacion',
			'idespecie' => 'Idespecie',
			'idtemporada' => 'Idtemporada',
			'sdeclarada' => 'Declarada (TN)',
			'sdescargada' => 'Descargada (TN)',
			'horasta' => 'Hora tot',
			'sd2' => 'Diesel',
			'sct' => 'GL/Tn',
			'd2porhora' => 'GL/Hr',
			'sfd' => 'Factor Descarga',
			'nomespecie' => 'Especie',
			'bodega' => 'Bodega',
			'eficienciabodega' => 'Ef Bodeg',
			//'horas' => 'Horas',
			
			
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
		$criteria->compare('sdescargada',$this->sdescargada);
		$criteria->compare('sd2',$this->sd2,true);
		$criteria->compare('sct',$this->sct,true);
		$criteria->compare('sfd',$this->sfd,true);
		$criteria->compare('nomespecie',$this->nomespecie,true);
		$criteria->compare('bodega',$this->bodega,true);
		$criteria->compare('eficienciabodega',$this->eficienciabodega,true);
		$criteria->compare('horas',$this->horas,true);
		$criteria->compare('d2porhora',$this->d2porhora,true);
		$criteria->compare('horasta',$this->horasta);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function search_temporada($idtemporada)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('codep',$this->codep,true);
		$criteria->compare('nomep',$this->nomep,true);
		$criteria->compare('idespecie',$this->idespecie);
		$criteria->compare('idtemporada',$this->idtemporada);
		$criteria->compare('sdeclarada',$this->sdeclarada,true);
		$criteria->compare('sdescargada',$this->sdescargada);
		$criteria->compare('sd2',$this->sd2,true);
		$criteria->compare('sct',$this->sct,true);
		$criteria->compare('sfd',$this->sfd,true);
		$criteria->compare('nomespecie',$this->nomespecie,true);
		$criteria->compare('bodega',$this->bodega,true);
		$criteria->compare('eficienciabodega',$this->eficienciabodega,true);
		$criteria->compare('horas',$this->horas,true);
		$criteria->compare('d2porhora',$this->d2porhora,true);
		$criteria->compare('horasta',$this->horasta);
		$criteria->addCondition("idtemporada= ".$idtemporada);
		
	//	return new CActiveDataProvider($this, array('criteria'=>$criteria),	'pagination'=>array('pageSize'=>50));
		
		
		//	return  new  CActiveDataProvider($this, array('criteria'=>$criteria ), 	'pagination'=>array('pageSize'=>50));

		
	//	return new CActiveDataProvider($this, array('criteria'=>$criteria, 'pagination'=>array('pageSize'=>50) )); 


			/*return new CActiveDataProvider($this,
										array(
												'criteria' => $criteria,
												'pagination' => array('pageSize' => 100,),
												'totalItemCount' => 100,

											)
											
										);*/
		
		
		return new  CActiveDataProvider($this, array(
									'criteria'=>$criteria,
									'sort'=>array(
									'defaultOrder'=>'nomep asc',
            )						,
            'pagination' => array(
                'pageSize' => 40,
            ),

									
									));	
		
		
	}
	
	public function search_barco_temporada($idtemporada,$idespecie,$codep)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('codep',$this->codep,true);
		$criteria->compare('nomep',$this->nomep,true);
		$criteria->compare('idespecie',$this->idespecie);
		$criteria->compare('idtemporada',$this->idtemporada);
		$criteria->compare('sdeclarada',$this->sdeclarada,true);
		$criteria->compare('sdescargada',$this->sdescargada);
		$criteria->compare('sd2',$this->sd2,true);
		$criteria->compare('sct',$this->sct,true);
		$criteria->compare('sfd',$this->sfd,true);
		$criteria->compare('nomespecie',$this->nomespecie,true);
		$criteria->compare('bodega',$this->bodega,true);
		$criteria->compare('eficienciabodega',$this->eficienciabodega,true);
		$criteria->compare('horas',$this->horas,true);
		$criteria->compare('d2porhora',$this->d2porhora,true);
		$criteria->compare('horasta',$this->horasta);
		$criteria->addCondition("idtemporada= ".$idtemporada);
		$criteria->addCondition("idespecie= ".$idespecie);
		$criteria->addCondition("codep= '".$codep."'");
		return new  CActiveDataProvider($this, array(
									'criteria'=>$criteria,
									'sort'=>array(
									'defaultOrder'=>'nomep asc',
            )						,
            'pagination' => array(
                'pageSize' => 40,
            ),

									
									));	
		
		
	}
	
	
}