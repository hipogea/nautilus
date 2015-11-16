<?php

/**
 * This is the model class for table "vw_pesca_embarcaciones_parametros".
 *
 * The followings are the available columns in table 'vw_pesca_embarcaciones_parametros':
 * @property string $codep
 * @property string $nomep
 * @property string $fecha
 * @property integer $idespecie
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
class VwPescaEmbarcacionesParametros extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwPescaEmbarcacionesParametros the static model class
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
		return 'vw_pesca_embarcaciones_parametros';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idespecie', 'numerical', 'integerOnly'=>true),
			array('sdescargada, horasta', 'numerical'),
			array('codep', 'length', 'max'=>3),
			array('nomep', 'length', 'max'=>25),
			array('nomespecie', 'length', 'max'=>50),
			array('fecha, sdeclarada, sd2, sct, sfd, bodega, eficienciabodega, horas, d2porhora', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codep, nomep, fecha, idespecie, sdeclarada, sdescargada, sd2, sct, sfd, nomespecie, bodega, eficienciabodega, horas, d2porhora, horasta', 'safe', 'on'=>'search'),
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
			'fecha' => 'Fecha',
			'idespecie' => 'Idespecie',
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
	public function search($idtemporada,$idespecie)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('codep',$this->codep,true);
		$criteria->compare('nomep',$this->nomep,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('idespecie',$this->idespecie);
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
	
	
	public function search_parametros($idtemporada,$idespecie,$codep)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('codep',$this->codep,true);
		$criteria->compare('nomep',$this->nomep,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('idespecie',$this->idespecie);
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
		$criteria->addCondition("codep = '".$codep."'");
		$criteria->addCondition("idtemporada = ".$idtemporada);
		$criteria->addCondition("idespecie = ".$idespecie);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			 'pagination' => array(
                'pageSize' => 100,
            ),
		));
	}
	
	public function retornadatos ($idtemporada,$idespecie,$codep) {
			 $ancho=$this->model()->search_parametros($idtemporada,$idespecie,$codep)->getdata();
			// echo count($ancho);
			 //obteniendo las fechas 
				
		if (count($ancho) >0 and sort($ancho)) {
				$fechas=array()	; //las absicas
					$pescas=array(); //para guardar la pesca descragada
					$combustibles=array(); //para guardar los petroleso consumidos 
					$combustiblesporhora=array(); //petrole por hora 
					$combustibleportonelada=array();//petroleo por hora 
					$eficiencias=array();//eficiencias de bodega 
					$horastrabajadas=array();//hora trabajadas 
					
					//$acumulado=array();
					$meta=array();
							$i=0;
								foreach ($ancho as $clave => $valor) {
											$fechas[$i]=substr($ancho[$i]['fecha'],5,5)	;
											$pescas[$i]=$ancho[$i]['sdescargada']+0	;
											$combustibles[$i]=$ancho[$i]['sd2']+0	;
											$combustiblesporhora[$i]=$ancho[$i]['d2porhora']+0	;
											$combustibleportonelada[$i]=$ancho[$i]['sct']+0	;
											$eficiencias[$i]=$ancho[$i]['eficienciabodega']+0	;
											$horastrabajadas[$i]=$ancho[$i]['horasta']+0	;
											$i=$i+1;
													}
	  return array(
					'nombrebarco'=>$ancho[0]['nomep'],
					'fechas'=>$fechas, //las absicas
					'pescas'=>$pescas, //para guardar la pesca descragada
					'combustibles'=>$combustibles, //para guardar los petroleso consumidos 
					'combustibleporhora'=>$combustiblesporhora, //petrole por hora 
					'combustibleportonelada'=>$combustibleportonelada,//petroleo por hora 
					'eficiencias'=>$eficiencias,//eficiencias de bodega 
					'horastrabajadas'=>$horastrabajadas,//hora trabajadas 
					);
					
					}else {
					return null;
					}
	
	}
	
	
	
}