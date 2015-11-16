<?php

/**
 * This is the model class for table "vw_reportepesca_por_dia".
 *
 * The followings are the available columns in table 'vw_reportepesca_por_dia':
 * @property string $fecha
 * @property integer $idespecie
 * @property integer $idtemporada
 * @property string $sdeclarada
 * @property string $sdescargada
 * @property string $sd2
 * @property string $sct
 * @property string $sfd
 */
class VwReportepescaPorDia extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwReportepescaPorDia the static model class
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
		return 'vw_reportepesca_por_dia';
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
			array('sct', 'length', 'max'=>10),
			array('fecha, sdeclarada, sdescargada, sd2, sfd', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('fecha,eficienciabodega idespecie, idtemporada, sdeclarada, sdescargada, sd2, sct, sfd', 'safe', 'on'=>'search'),
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
			'sdeclarada' => 'Declarada (TN)',
			'sdescargada' => 'Descargada (TN)',
			'sd2' => 'D2 (Gl)',
			'd2porhora' => 'D2 hora (Gl/Hr)',
			'sct' => 'D2 Tonelada (Gl/Tn)',
			'sfd' => 'Fac.Desc.',
			'eficienciabodega' => 'Efic Bod',
			'bodega' => 'Bod. Disp',
			'horasta' => 'Horas',			
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
		$criteria->compare('eficienciabodega',$this->eficienciabodega,true);
		$criteria->compare('sd2',$this->sd2,true);
		$criteria->compare('sct',$this->sct,true);
		$criteria->compare('sfd',$this->sfd,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function search_por_temporada($idtemporada,$idespecie)
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
		$criteria->addCondition("idtemporada = ".$idtemporada."");
		$criteria->addCondition("idespecie = ".$idespecie."");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	
	public function search_por_dia_anchoveta($idtemporada)
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
		//$criteria->addCondition("fecha= '".$fecha."'");
		//$criteria->addCondition("idespecie=1");
		//$criteria->addCondition("idtemporada=".$idtemporada);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,'pagination' => array(
                'pageSize' => 400,
            ),
		));
	}
	
	
	public function search_por_dia_jurel($idtemporada)
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
		//$criteria->addCondition("fecha= '".$fecha."'");
		//$criteria->addCondition("idespecie=2");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}