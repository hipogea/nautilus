<?php

/**
 * This is the model class for table "vw_maestroclasificacion".
 *
 * The followings are the available columns in table 'vw_maestroclasificacion':
 * @property string $texto
 * @property string $descri
 * @property string $chapas
 * @property integer $idatributos
 * @property string $hid
 * @property string $nombreat
 * @property string $aabr
 * @property string $respaldo
 * @property string $respaldo2
 * @property string $respaldo3
 * @property string $textatributos
 * @property string $nombrevalor
 * @property string $hidat
 * @property string $abreviatura
 * @property string $textvalores
 * @property string $respaldo1
 * @property string $resp2
 * @property string $resultado
 * @property integer $idgrupos
 * @property integer $idvalores
 */
class Vwmaestroclasificacion extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Vwmaestroclasificacion the static model class
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
		return 'vw_maestroclasificacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idatributos, idgrupos, idvalores', 'numerical', 'integerOnly'=>true),
			array('descri, nombreat', 'length', 'max'=>20),
			array('chapas', 'length', 'max'=>75),
			array('aabr', 'length', 'max'=>4),
			array('respaldo, respaldo2, respaldo3', 'length', 'max'=>60),
			array('nombrevalor, respaldo1, resp2', 'length', 'max'=>40),
			array('abreviatura', 'length', 'max'=>5),
			array('resultado', 'length', 'max'=>10),
			array('texto, hid, textatributos, hidat, textvalores', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('texto, descri, chapas, idatributos, hid, nombreat, aabr, respaldo, respaldo2, respaldo3, textatributos, nombrevalor, hidat, abreviatura, textvalores, respaldo1, resp2, resultado, idgrupos, idvalores', 'safe', 'on'=>'search'),
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
			'texto' => 'Texto',
			'descri' => 'Descri',
			'chapas' => 'Chapas',
			'idatributos' => 'Idatributos',
			'hid' => 'Hid',
			'nombreat' => 'Nombreat',
			'aabr' => 'Aabr',
			'respaldo' => 'Respaldo',
			'respaldo2' => 'Respaldo2',
			'respaldo3' => 'Respaldo3',
			'textatributos' => 'Textatributos',
			'nombrevalor' => 'Nombrevalor',
			'hidat' => 'Hidat',
			'abreviatura' => 'Abreviatura',
			'textvalores' => 'Textvalores',
			'respaldo1' => 'Respaldo1',
			'resp2' => 'Resp2',
			'resultado' => 'Resultado',
			'idgrupos' => 'Idgrupos',
			'idvalores' => 'Idvalores',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search2($valor)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		//$criteria->compare('texto',$this->texto,true);
		$criteria->compare('descri',$valor,true);
		
		//$criteria->addCondition("descri= '".$fecha."'");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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

		$criteria->compare('texto',$this->texto,true);
		$criteria->compare('descri',$this->descri,true);
		$criteria->compare('chapas',$this->chapas,true);
		$criteria->compare('idatributos',$this->idatributos);
		$criteria->compare('hid',$this->hid,true);
		$criteria->compare('nombreat',$this->nombreat,true);
		$criteria->compare('aabr',$this->aabr,true);
		$criteria->compare('respaldo',$this->respaldo,true);
		$criteria->compare('respaldo2',$this->respaldo2,true);
		$criteria->compare('respaldo3',$this->respaldo3,true);
		$criteria->compare('textatributos',$this->textatributos,true);
		$criteria->compare('nombrevalor',$this->nombrevalor,true);
		$criteria->compare('hidat',$this->hidat,true);
		$criteria->compare('abreviatura',$this->abreviatura,true);
		$criteria->compare('textvalores',$this->textvalores,true);
		$criteria->compare('respaldo1',$this->respaldo1,true);
		$criteria->compare('resp2',$this->resp2,true);
		$criteria->compare('resultado',$this->resultado,true);
		$criteria->compare('idgrupos',$this->idgrupos);
		$criteria->compare('idvalores',$this->idvalores);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}